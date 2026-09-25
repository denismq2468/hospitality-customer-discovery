# Hospitality Customer Discovery

Research and development for identifying recurring problems in cafés, restaurants and hospitality businesses, and exploring practical solutions using automation, software and AI.

## Scope
This repository is intentionally separate from the Beatles website and other Quinland projects. It contains the safe source for the hospitality customer-discovery survey at quinland.online/cafe/.

## Architecture
Browser index.html -> Hostinger submit.php -> Hostinger MySQL.

The supplied V1 PHP showed no Brevo integration. Live database credentials must remain on Hostinger and must never be committed here.

## V2
V2 changes the survey from a predetermined free/Microsoft Office tool proposition to pain-first customer discovery. Business name remains compulsory. Open-ended questions precede prompted categories. V2 writes to a separate survey_responses_v2 table so V1 data and question meanings remain intact.

## Deployment
1. Run database/migration_v2.sql in Hostinger MySQL.
2. Create config.private.php on Hostinger from config.example.php using the live credentials.
3. Deploy index.html and submit.php to the cafe directory.
4. Make a test submission and verify the database row before distributing the survey.

Do not commit config.private.php or any credentials.
