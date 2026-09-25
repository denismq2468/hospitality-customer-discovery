-- Hospitality Customer Discovery Survey V2
-- Run on Hostinger MySQL before deploying the V2 submit.php.
-- Preserves the existing V1 survey_responses table unchanged.
CREATE TABLE survey_responses_v2 (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
 business_name VARCHAR(255) NOT NULL,
 biggest_problems TEXT NOT NULL,
 eliminate_task TEXT NULL,
 unwanted_owner_work TEXT NULL,
 impact_cost_time TEXT NULL,
 current_approach TEXT NULL,
 current_paid_tools_services TEXT NULL,
 prompted_problem_areas TEXT NULL,
 prompted_problem_areas_other TEXT NULL,
 delivery_platforms TEXT NULL,
 ai_usage TEXT NULL,
 priority_problem TEXT NOT NULL,
 followup_name VARCHAR(255) NULL,
 followup_email_phone VARCHAR(255) NULL,
 followup_permission VARCHAR(10) NOT NULL DEFAULT 'No',
 survey_version VARCHAR(64) NOT NULL DEFAULT 'hospitality-discovery-v2',
 submitted_at DATETIME NOT NULL,
 ip_hash CHAR(64) NULL,
 PRIMARY KEY (id),
 INDEX idx_business_name (business_name),
 INDEX idx_submitted_at (submitted_at),
 INDEX idx_survey_version (survey_version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
