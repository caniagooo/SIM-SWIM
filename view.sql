-- aktif course--
CREATE OR REPLACE VIEW active_courses AS
SELECT 
    c.id AS course_id,
    c.name AS course_name,
    c.type,
    c.start_date,
    c.valid_until,
    c.max_sessions,
    v.name AS venue_name,

   -- Pelatih
    GROUP_CONCAT(DISTINCT t.id ORDER BY t.id SEPARATOR ',') AS trainer_ids,
    GROUP_CONCAT(DISTINCT u_trainer.name ORDER BY u_trainer.name SEPARATOR ', ') AS trainer_names,
    GROUP_CONCAT(DISTINCT u_trainer.profile_photo_path SEPARATOR ',') AS trainer_avatars,


    -- Siswa
    GROUP_CONCAT(DISTINCT u_student.name ORDER BY u_student.name SEPARATOR ', ') AS student_names,
    GROUP_CONCAT(DISTINCT s.id ORDER BY u_student.name SEPARATOR ',') AS student_ids,
    GROUP_CONCAT(DISTINCT u_student.profile_photo_path SEPARATOR ',') AS student_avatars,


    -- Sesi selesai
    COUNT(DISTINCT cs.id) AS completed_session_count,

    -- Sesi terdekat
    MIN(CASE 
        WHEN sess.status = 'scheduled' AND sess.session_date >= CURRENT_DATE 
        THEN sess.session_date 
        ELSE NULL 
    END) AS next_session_date,

    cp.status AS payment_status

FROM courses c
JOIN course_payments cp ON cp.course_id = c.id AND cp.status = 'paid'
LEFT JOIN venues v ON v.id = c.venue_id

-- Pelatih
LEFT JOIN course_trainer ct ON ct.course_id = c.id
LEFT JOIN trainers t ON t.id = ct.trainer_id
LEFT JOIN users u_trainer ON u_trainer.id = t.user_id

-- Siswa
LEFT JOIN course_student cs_student ON cs_student.course_id = c.id
LEFT JOIN students s ON s.id = cs_student.student_id
LEFT JOIN users u_student ON u_student.id = s.user_id

-- Sesi selesai
LEFT JOIN course_sessions cs ON cs.course_id = c.id AND cs.status = 'completed'
LEFT JOIN attendances a ON a.course_session_id = cs.id

-- Semua sesi (untuk cari sesi terdekat)
LEFT JOIN course_sessions sess ON sess.course_id = c.id

WHERE CURRENT_DATE BETWEEN c.start_date AND c.valid_until

GROUP BY 
    c.id, c.name, c.type, c.start_date, c.valid_until, c.max_sessions,
    v.name, cp.status

HAVING COUNT(DISTINCT cs.id) < c.max_sessions;





-- course student active--
CREATE OR REPLACE VIEW course_student_active AS
SELECT 
    cs.student_id,
    s.user_id,
    u.name AS student_name,
    u.email AS student_email,
    c.id AS course_id,
    c.name AS course_name,
    c.start_date,
    c.valid_until,
    c.max_sessions,
    COUNT(DISTINCT ses.id) AS completed_sessions
FROM course_student cs
JOIN students s ON s.id = cs.student_id
JOIN users u ON u.id = s.user_id
JOIN courses c ON c.id = cs.course_id
JOIN course_payments cp ON cp.course_id = c.id AND cp.status = 'paid'
LEFT JOIN course_sessions ses ON ses.course_id = c.id AND ses.status = 'completed'
WHERE CURRENT_DATE BETWEEN c.start_date AND c.valid_until
GROUP BY cs.student_id, cs.course_id, s.user_id, u.name, u.email, c.id, c.name, c.start_date, c.valid_until, c.max_sessions
HAVING COUNT(DISTINCT ses.id) < c.max_sessions;


-- dashboard overview--
CREATE OR REPLACE VIEW dashboard_overview AS
SELECT 
    (SELECT COUNT(*) FROM users) AS total_users,
    (SELECT COUNT(*) FROM students) AS total_students,
    (SELECT COUNT(*) FROM trainers) AS total_trainers,
    (SELECT COUNT(*) FROM courses WHERE start_date <= CURDATE() AND valid_until >= CURDATE()) AS active_courses,
    (SELECT COUNT(*) FROM course_sessions WHERE status = 'completed') AS completed_sessions,
    (SELECT SUM(amount) FROM course_payments WHERE status = 'paid') AS total_income
;

-- session attendance stats --
CREATE OR REPLACE VIEW session_attendance_stats AS
SELECT 
    DATE_FORMAT(cs.session_date, '%Y-%m') AS month,
    a.status,
    COUNT(*) AS count
FROM attendances a
JOIN course_sessions cs ON cs.id = a.course_session_id
GROUP BY month, a.status
ORDER BY month DESC;

-- course payment monthly --
CREATE OR REPLACE VIEW payment_summary_by_month AS
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') AS month,
    COUNT(*) AS total_payments,
    SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) AS total_paid,
    SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) AS total_pending,
    SUM(amount) AS total_amount
FROM course_payments
GROUP BY month
ORDER BY month DESC;


-- trainer activity summary --
CREATE OR REPLACE VIEW trainer_activity_summary AS
SELECT 
    t.id AS trainer_id,
    u.name AS trainer_name,
    COUNT(DISTINCT ct.course_id) AS total_courses,
    COUNT(DISTINCT cst.course_session_id) AS total_sessions,
    SUM(CASE WHEN cs.status = 'completed' THEN 1 ELSE 0 END) AS sessions_completed
FROM trainers t
JOIN users u ON u.id = t.user_id
LEFT JOIN course_trainer ct ON ct.trainer_id = t.id
LEFT JOIN course_sessions cs ON cs.course_id = ct.course_id
LEFT JOIN course_session_trainer cst ON cst.course_session_id = cs.id AND cst.trainer_id = t.id
GROUP BY t.id, u.name;

-- student progress summary --
CREATE OR REPLACE VIEW student_progress_summary AS
SELECT 
    sg.student_id,
    u.name AS student_name,
    COUNT(sg.material_id) AS total_materials,
    AVG(sg.score) AS average_score
FROM student_grades sg
JOIN students s ON s.id = sg.student_id
JOIN users u ON u.id = s.user_id
GROUP BY sg.student_id, u.name;



-- past course sessions --
CREATE OR REPLACE VIEW past_course_sessions AS
SELECT 
    cs.id AS session_id,
    cs.course_id,
    c.name AS course_name,
    cs.session_date,
    cs.status,
    v.name AS venue_name,
    GROUP_CONCAT(DISTINCT u.name ORDER BY u.name SEPARATOR ', ') AS trainer_names
FROM course_sessions cs
JOIN courses c ON c.id = cs.course_id
LEFT JOIN venues v ON v.id = c.venue_id
LEFT JOIN course_session_trainer cst ON cst.course_session_id = cs.id
LEFT JOIN trainers t ON t.id = cst.trainer_id
LEFT JOIN users u ON u.id = t.user_id
WHERE cs.session_date < CURRENT_DATE
GROUP BY cs.id, cs.course_id, c.name, cs.session_date, cs.status, v.name;

-- session monthly summary --
CREATE OR REPLACE VIEW session_monthly_summary AS
SELECT 
    CASE 
        WHEN MONTH(cs.session_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) THEN 'last_month'
        WHEN MONTH(cs.session_date) = MONTH(CURRENT_DATE) THEN 'this_month'
        WHEN MONTH(cs.session_date) = MONTH(CURRENT_DATE + INTERVAL 1 MONTH) THEN 'next_month'
        ELSE 'other'
    END AS period,
    COUNT(*) AS session_count
FROM course_sessions cs
WHERE cs.session_date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)
                          AND DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH)
GROUP BY period;
