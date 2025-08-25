# Dashboard Optimization Commands

To help resolve the timeout issues and improve dashboard performance, here are some useful commands:

## Clear Dashboard Cache
```bash
php artisan cache:forget dashboard_centre_performance
php artisan cache:forget dashboard_subject_performance
php artisan cache:forget dashboard_capacity_utilization
php artisan cache:forget dashboard_top_scorers
```

Or clear all cache:
```bash
php artisan cache:clear
```

## Optimize Laravel Performance
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Database Query Optimization
Consider adding these database indexes to improve query performance:

```sql
-- For centres table
ALTER TABLE centres ADD INDEX idx_centres_id_name (id, name);

-- For venues table  
ALTER TABLE venues ADD INDEX idx_venues_centre_capacity (centre_id, capacity);

-- For scheduled_candidates table
ALTER TABLE scheduled_candidates ADD INDEX idx_scheduled_candidates_schedule_candidate (schedule_id, candidate_id);

-- For scores table
ALTER TABLE scores ADD INDEX idx_scores_scheduled_candidate_point (scheduled_candidate_id, point_scored);

-- For time_controls table
ALTER TABLE time_controls ADD INDEX idx_time_controls_scheduled_completed (scheduled_candidate_id, completed);
```

## Monitor Database Performance
```bash
# Enable slow query log in MySQL
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
SET GLOBAL slow_query_log_file = '/var/log/mysql/slow.log';
```

## Laravel Queue for Heavy Operations
If timeouts persist, consider moving heavy dashboard queries to background jobs:

```bash
php artisan make:job GenerateDashboardCache
php artisan queue:work
```
