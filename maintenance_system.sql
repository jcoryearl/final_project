-- ============================================================================
-- PREVENTIVE MAINTENANCE TASK SCHEDULING SYSTEM
-- MySQL Database Dump
-- Created: 2026-05-17
-- Purpose: Web-based preventive maintenance scheduling with notifications,
--          task management, and issue escalation
-- ============================================================================

SET FOREIGN_KEY_CHECKS=0;

-- ============================================================================
-- TABLE: users
-- Purpose: Store all system users (technicians, supervisors, administrators)
-- ============================================================================
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('technician', 'supervisor', 'admin') NOT NULL DEFAULT 'technician',
    department VARCHAR(100),
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    last_login DATETIME,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: notification_preferences
-- Purpose: Store user email notification preferences
-- ============================================================================
CREATE TABLE IF NOT EXISTS notification_preferences (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    task_assigned TINYINT(1) NOT NULL DEFAULT 1,
    task_reminder TINYINT(1) NOT NULL DEFAULT 1,
    task_completed TINYINT(1) NOT NULL DEFAULT 1,
    task_issue_reported TINYINT(1) NOT NULL DEFAULT 1,
    daily_digest TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_notif_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_prefs (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: equipment
-- Purpose: Store equipment/assets that require maintenance
-- ============================================================================
CREATE TABLE IF NOT EXISTS equipment (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    equipment_type VARCHAR(100),
    manufacturer VARCHAR(150),
    model VARCHAR(100),
    serial_number VARCHAR(100),
    location VARCHAR(255),
    purchase_date DATE,
    warranty_expiry DATE,
    status ENUM('active', 'inactive', 'retired', 'under_maintenance') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_equipment_type (equipment_type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: maintenance_templates
-- Purpose: Pre-configured maintenance task templates for recurring tasks
-- ============================================================================
CREATE TABLE IF NOT EXISTS maintenance_templates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    estimated_labor_hours DECIMAL(5, 2) NOT NULL,
    tools_required JSON COMMENT 'Array of tool names needed',
    supplies_required JSON COMMENT 'Array of supplies (part numbers, quantities)',
    instructions TEXT,
    recurrence_interval INT COMMENT 'Days between maintenance cycles',
    priority ENUM('low', 'medium', 'high', 'critical') NOT NULL DEFAULT 'medium',
    created_by INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_template_equipment FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
    CONSTRAINT fk_template_creator FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_equipment_id (equipment_id),
    INDEX idx_recurrence (recurrence_interval)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: maintenance_tasks
-- Purpose: Individual maintenance tasks (instances created from templates)
-- ============================================================================
CREATE TABLE IF NOT EXISTS maintenance_tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id INT UNSIGNED,
    equipment_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    estimated_labor_hours DECIMAL(5, 2) NOT NULL,
    tools_required JSON COMMENT 'Array of tool names needed',
    supplies_required JSON COMMENT 'Array of supplies (part numbers, quantities)',
    status ENUM('scheduled', 'in_progress', 'completed', 'cancelled', 'postponed', 'on_hold') NOT NULL DEFAULT 'scheduled',
    priority ENUM('low', 'medium', 'high', 'critical') NOT NULL DEFAULT 'medium',
    scheduled_date DATE NOT NULL,
    scheduled_start_time TIME,
    scheduled_end_time TIME,
    actual_start_time DATETIME,
    actual_end_time DATETIME,
    actual_labor_hours DECIMAL(5, 2),
    assigned_to INT UNSIGNED,
    created_by INT UNSIGNED NOT NULL,
    notes TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_task_template FOREIGN KEY (template_id) REFERENCES maintenance_templates(id) ON DELETE SET NULL,
    CONSTRAINT fk_task_equipment FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
    CONSTRAINT fk_task_assigned_to FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_task_created_by FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_equipment_id (equipment_id),
    INDEX idx_status (status),
    INDEX idx_scheduled_date (scheduled_date),
    INDEX idx_assigned_to (assigned_to),
    INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: task_notifications
-- Purpose: Track email notifications sent for each task
-- ============================================================================
CREATE TABLE IF NOT EXISTS task_notifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id INT UNSIGNED NOT NULL,
    recipient_user_id INT UNSIGNED NOT NULL,
    notification_type ENUM('task_assigned', 'task_reminder', 'task_completed', 'task_issue_reported') NOT NULL,
    subject VARCHAR(255),
    email_body TEXT,
    sent_at DATETIME,
    sent_successfully TINYINT(1) NOT NULL DEFAULT 0,
    error_message TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notif_task FOREIGN KEY (task_id) REFERENCES maintenance_tasks(id) ON DELETE CASCADE,
    CONSTRAINT fk_notif_recipient FOREIGN KEY (recipient_user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_task_id (task_id),
    INDEX idx_recipient_user_id (recipient_user_id),
    INDEX idx_notification_type (notification_type),
    INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: task_completion_reports
-- Purpose: Document task completion with photos, notes, and outcomes
-- ============================================================================
CREATE TABLE IF NOT EXISTS task_completion_reports (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id INT UNSIGNED NOT NULL,
    completed_by INT UNSIGNED NOT NULL,
    completion_notes TEXT NOT NULL,
    parts_replaced JSON COMMENT 'Array of parts used and quantities',
    photo_attachments JSON COMMENT 'Array of file paths to uploaded photos',
    work_performed TEXT,
    findings TEXT COMMENT 'Any observations or findings during task',
    next_maintenance_recommendation TEXT,
    signature_required TINYINT(1) NOT NULL DEFAULT 1,
    supervisor_signature TINYINT(1) NOT NULL DEFAULT 0,
    supervisor_name VARCHAR(255),
    completed_at DATETIME NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_report_task FOREIGN KEY (task_id) REFERENCES maintenance_tasks(id) ON DELETE CASCADE,
    CONSTRAINT fk_report_technician FOREIGN KEY (completed_by) REFERENCES users(id),
    INDEX idx_task_id (task_id),
    INDEX idx_completed_by (completed_by),
    INDEX idx_supervisor_signature (supervisor_signature)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: task_issues
-- Purpose: Track issues/problems reported during task execution
-- ============================================================================
CREATE TABLE IF NOT EXISTS task_issues (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id INT UNSIGNED NOT NULL,
    reported_by INT UNSIGNED NOT NULL,
    issue_type ENUM('equipment_failure', 'safety_concern', 'missing_parts', 'unable_to_complete', 'unexpected_finding', 'other') NOT NULL,
    severity ENUM('low', 'medium', 'high', 'critical') NOT NULL DEFAULT 'medium',
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    photos JSON COMMENT 'Array of file paths to issue photos',
    reported_at DATETIME NOT NULL,
    status ENUM('reported', 'acknowledged', 'in_investigation', 'resolved', 'closed') NOT NULL DEFAULT 'reported',
    notified_supervisors TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_issue_task FOREIGN KEY (task_id) REFERENCES maintenance_tasks(id) ON DELETE CASCADE,
    CONSTRAINT fk_issue_reporter FOREIGN KEY (reported_by) REFERENCES users(id),
    INDEX idx_task_id (task_id),
    INDEX idx_reported_by (reported_by),
    INDEX idx_severity (severity),
    INDEX idx_status (status),
    INDEX idx_reported_at (reported_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: issue_notifications
-- Purpose: Track notifications sent to supervisors about reported issues
-- ============================================================================
CREATE TABLE IF NOT EXISTS issue_notifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    issue_id INT UNSIGNED NOT NULL,
    supervisor_user_id INT UNSIGNED NOT NULL,
    subject VARCHAR(255),
    email_body TEXT,
    sent_at DATETIME,
    sent_successfully TINYINT(1) NOT NULL DEFAULT 0,
    error_message TEXT,
    acknowledged_at DATETIME,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_issue_notif_issue FOREIGN KEY (issue_id) REFERENCES task_issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_issue_notif_supervisor FOREIGN KEY (supervisor_user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_issue_id (issue_id),
    INDEX idx_supervisor_user_id (supervisor_user_id),
    INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: issue_responses
-- Purpose: Track supervisor responses to reported issues
-- ============================================================================
CREATE TABLE IF NOT EXISTS issue_responses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    issue_id INT UNSIGNED NOT NULL,
    responded_by INT UNSIGNED NOT NULL,
    response_text TEXT NOT NULL,
    action_taken VARCHAR(255),
    approval_status ENUM('approved', 'needs_revision', 'cancelled', 'pending') NOT NULL DEFAULT 'pending',
    responded_at DATETIME NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_response_issue FOREIGN KEY (issue_id) REFERENCES task_issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_response_responder FOREIGN KEY (responded_by) REFERENCES users(id),
    INDEX idx_issue_id (issue_id),
    INDEX idx_responded_by (responded_by),
    INDEX idx_approval_status (approval_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: task_assignments
-- Purpose: Track task assignments and reassignments
-- ============================================================================
CREATE TABLE IF NOT EXISTS task_assignments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_id INT UNSIGNED NOT NULL,
    assigned_to INT UNSIGNED NOT NULL,
    assigned_by INT UNSIGNED NOT NULL,
    assignment_notes TEXT,
    reassignment_reason VARCHAR(255),
    assigned_at DATETIME NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_assignment_task FOREIGN KEY (task_id) REFERENCES maintenance_tasks(id) ON DELETE CASCADE,
    CONSTRAINT fk_assignment_technician FOREIGN KEY (assigned_to) REFERENCES users(id),
    CONSTRAINT fk_assignment_assigner FOREIGN KEY (assigned_by) REFERENCES users(id),
    INDEX idx_task_id (task_id),
    INDEX idx_assigned_to (assigned_to)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: maintenance_schedules
-- Purpose: Recurring maintenance schedules based on templates
-- ============================================================================
CREATE TABLE IF NOT EXISTS maintenance_schedules (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id INT UNSIGNED NOT NULL,
    recurrence_type ENUM('daily', 'weekly', 'monthly', 'quarterly', 'yearly', 'as_needed') NOT NULL,
    recurrence_interval INT,
    day_of_week VARCHAR(50) COMMENT 'For weekly schedules: comma-separated day numbers',
    day_of_month INT COMMENT 'For monthly schedules: day of month (1-31)',
    start_date DATE NOT NULL,
    end_date DATE,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    next_task_date DATE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_schedule_template FOREIGN KEY (template_id) REFERENCES maintenance_templates(id) ON DELETE CASCADE,
    INDEX idx_template_id (template_id),
    INDEX idx_is_active (is_active),
    INDEX idx_next_task_date (next_task_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: maintenance_history
-- Purpose: Historical log of all maintenance performed on equipment
-- ============================================================================
CREATE TABLE IF NOT EXISTS maintenance_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED,
    maintenance_date DATE NOT NULL,
    maintenance_type ENUM('preventive', 'corrective', 'emergency', 'inspection') NOT NULL,
    technician_name VARCHAR(255),
    labor_hours DECIMAL(5, 2),
    parts_cost DECIMAL(10, 2),
    labor_cost DECIMAL(10, 2),
    description TEXT,
    outcome ENUM('completed', 'failed', 'partial', 'cancelled') NOT NULL,
    next_due_date DATE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_history_equipment FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
    CONSTRAINT fk_history_task FOREIGN KEY (task_id) REFERENCES maintenance_tasks(id) ON DELETE SET NULL,
    INDEX idx_equipment_id (equipment_id),
    INDEX idx_maintenance_date (maintenance_date),
    INDEX idx_maintenance_type (maintenance_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: system_settings
-- Purpose: Store system configuration and settings
-- ============================================================================
CREATE TABLE IF NOT EXISTS system_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('string', 'integer', 'boolean', 'json') NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: audit_log
-- Purpose: Log all user actions for compliance and troubleshooting
-- ============================================================================
CREATE TABLE IF NOT EXISTS audit_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    action VARCHAR(255) NOT NULL,
    entity_type VARCHAR(100),
    entity_id INT UNSIGNED,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_entity_type (entity_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;

-- ============================================================================
-- SAMPLE DATA INSERTION
-- ============================================================================

-- Sample Users
INSERT INTO users (first_name, last_name, email, phone, password_hash, role, department) VALUES
('John', 'Technician', 'john.tech@maintenance.local', '555-0001', SHA2('password123', 256), 'technician', 'Maintenance'),
('Sarah', 'Supervisor', 'sarah.sup@maintenance.local', '555-0002', SHA2('password123', 256), 'supervisor', 'Operations'),
('Mike', 'Admin', 'mike.admin@maintenance.local', '555-0003', SHA2('password123', 256), 'admin', 'Administration'),
('Jennifer', 'Technician', 'jen.tech@maintenance.local', '555-0004', SHA2('password123', 256), 'technician', 'Maintenance'),
('David', 'Supervisor', 'david.sup@maintenance.local', '555-0005', SHA2('password123', 256), 'supervisor', 'Operations');

-- Sample Notification Preferences
INSERT INTO notification_preferences (user_id, task_assigned, task_reminder, task_completed, task_issue_reported) VALUES
(1, 1, 1, 0, 1),
(2, 1, 1, 1, 1),
(3, 1, 0, 1, 1),
(4, 1, 1, 0, 1),
(5, 1, 1, 1, 1);

-- Sample Equipment
INSERT INTO equipment (name, description, equipment_type, manufacturer, model, serial_number, location, purchase_date, status) VALUES
('HVAC System - Building A', 'Central air conditioning unit for Building A', 'HVAC', 'Carrier', 'AquaEdge 19DV', 'SN-001-2022-1001', 'Rooftop Building A', '2022-03-15', 'active'),
('Boiler - Building B', 'Steam boiler for heating', 'Heating', 'Cleaver-Brooks', 'CB800', 'SN-002-2021-0502', 'Basement Building B', '2021-05-20', 'active'),
('Pump - Circulation System', 'Water circulation pump', 'Pump', 'Grundfos', 'TPE3 80-160', 'SN-003-2020-0801', 'Mechanical Room', '2020-08-10', 'active'),
('Compressor - Air System', 'Rotary screw air compressor', 'Compressor', 'Atlas Copco', 'GA45FF', 'SN-004-2021-1205', 'Equipment Room 2', '2021-12-01', 'active'),
('Fire Suppression System', 'Sprinkler system for all floors', 'Safety', 'Tyco Fire', 'Viking', 'SN-005-2019-0610', 'Throughout Building', '2019-06-15', 'active');

-- Sample Maintenance Templates
INSERT INTO maintenance_templates (equipment_id, name, description, estimated_labor_hours, tools_required, supplies_required, instructions, recurrence_interval, priority, created_by) VALUES
(1, 'HVAC Filter Change', 'Replace air filters and clean intake', 0.5, '["Screwdriver", "Wrench", "Flashlight"]', '[{"item": "Air Filter 20x25x1", "quantity": 4}, {"item": "Sealing tape", "quantity": 1}]', 'Turn off system, replace filters, clean housing, restart', 90, 'high', 3),
(1, 'HVAC Seasonal Inspection', 'Full seasonal inspection and preventive maintenance', 2.5, '["Multimeter", "Refrigerant gauge", "Wrench set", "Allen keys"]', '[{"item": "Refrigerant", "quantity": 1}, {"item": "O-rings assortment", "quantity": 1}]', 'Check all components, test electrical, measure pressures, lubricate motors', 180, 'medium', 3),
(2, 'Boiler Inspection and Service', 'Annual boiler inspection and cleaning', 3.0, '["Brush set", "Inspection camera", "Wrench set", "Pressure gauge"]', '[{"item": "Cleaning solution", "quantity": 2}, {"item": "Gasket material", "quantity": 1}]', 'Inspect burner, check draft, clean tubes, test safety valves', 365, 'high', 3),
(3, 'Pump Bearing Lubrication', 'Lubricate pump bearings', 0.75, '["Grease gun", "Socket set", "Gasket scraper"]', '[{"item": "Bearing grease ISO VG 100", "quantity": 1}]', 'Locate grease fittings, apply grease until resistance, clean excess', 180, 'medium', 3),
(4, 'Compressor Oil Change', 'Change compressor oil and filter', 1.5, '["Socket set", "Wrench", "Oil drain pan"]', '[{"item": "Compressor oil ISO VG 46", "quantity": 2}, {"item": "Oil filter", "quantity": 1}]', 'Drain old oil, replace filter, refill with correct oil level', 250, 'high', 3);

-- Sample Scheduled Tasks
INSERT INTO maintenance_tasks (template_id, equipment_id, title, description, estimated_labor_hours, tools_required, supplies_required, status, priority, scheduled_date, scheduled_start_time, scheduled_end_time, assigned_to, created_by) VALUES
(1, 1, 'HVAC Filter Replacement - Q2', 'Quarterly filter replacement for Building A HVAC', 0.5, '["Screwdriver", "Wrench", "Flashlight"]', '[{"item": "Air Filter 20x25x1", "quantity": 4}]', 'scheduled', 'high', '2026-05-20', '08:00:00', '09:00:00', 1, 3),
(2, 1, 'HVAC Seasonal Inspection - Spring', 'Spring preventive inspection before cooling season', 2.5, '["Multimeter", "Refrigerant gauge", "Wrench set"]', '[{"item": "Refrigerant", "quantity": 1}]', 'scheduled', 'medium', '2026-05-25', '09:00:00', '12:00:00', 1, 3),
(3, 2, 'Boiler Annual Service', 'Annual boiler inspection and maintenance', 3.0, '["Brush set", "Inspection camera"]', '[{"item": "Cleaning solution", "quantity": 2}]', 'scheduled', 'high', '2026-06-15', '10:00:00', '14:00:00', 4, 3),
(4, 3, 'Pump Bearing Maintenance', 'Lubricate pump bearings', 0.75, '["Grease gun", "Socket set"]', '[{"item": "Bearing grease ISO VG 100", "quantity": 1}]', 'in_progress', 'medium', '2026-05-18', '14:00:00', '15:00:00', 1, 3),
(5, 4, 'Compressor Oil Change', 'Change compressor oil and filter', 1.5, '["Socket set", "Wrench"]', '[{"item": "Compressor oil ISO VG 46", "quantity": 2}, {"item": "Oil filter", "quantity": 1}]', 'scheduled', 'high', '2026-05-22', '07:00:00', '09:00:00', 4, 3);

-- Sample Maintenance Schedules
INSERT INTO maintenance_schedules (template_id, recurrence_type, recurrence_interval, start_date, is_active, next_task_date) VALUES
(1, 'quarterly', 90, '2025-01-01', 1, '2026-05-20'),
(2, 'semi-annual', 180, '2025-01-01', 1, '2026-05-25'),
(3, 'yearly', 365, '2025-01-01', 1, '2026-06-15'),
(4, 'quarterly', 90, '2025-01-01', 1, '2026-05-18'),
(5, 'yearly', 250, '2025-01-01', 1, '2026-05-22');

-- Sample System Settings
INSERT INTO system_settings (setting_key, setting_value, setting_type, description) VALUES
('company_name', 'ABC Facilities Management', 'string', 'Company name for email headers'),
('notification_email_from', 'maintenance@abcfacilities.local', 'string', 'Email address for system notifications'),
('task_reminder_hours_before', '24', 'integer', 'Hours before scheduled task to send reminder'),
('supervisor_email_list', 'sarah.sup@maintenance.local,david.sup@maintenance.local', 'string', 'Comma-separated list of supervisor emails for issue notifications'),
('issue_auto_escalate_minutes', '30', 'integer', 'Minutes before auto-escalating unacknowledged issues'),
('max_task_assignment_days_in_advance', '60', 'integer', 'Maximum days in advance to schedule tasks'),
('enable_photo_uploads', 'true', 'boolean', 'Enable photo attachments for task completion reports'),
('required_supervisor_approval', 'true', 'boolean', 'Require supervisor approval for completed tasks');

-- ============================================================================
-- INDEXES FOR PERFORMANCE
-- ============================================================================

CREATE INDEX idx_tasks_scheduled_date_status ON maintenance_tasks(scheduled_date, status);
CREATE INDEX idx_tasks_assigned_to_status ON maintenance_tasks(assigned_to, status);
CREATE INDEX idx_issues_severity_status ON task_issues(severity, status);
CREATE INDEX idx_completion_supervisor_sig ON task_completion_reports(supervisor_signature);
CREATE INDEX idx_notifications_sent ON task_notifications(sent_successfully, sent_at);

-- ============================================================================
-- END OF DATABASE DUMP
-- ============================================================================