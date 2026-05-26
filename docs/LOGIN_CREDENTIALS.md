# Login URLs and Seeded Credentials

Run all seeders:

```bash
php artisan db:seed
```

Default local base URL from `.env`:

```text
http://127.0.0.1:8000
```

## Admin / Backend

Login URL: `/login`
Dashboard URL: `/admin/dashboard`

| Role | Login ID | Password |
| --- | --- | --- |
| Super Admin | admin@gmail.com | admin |
| Administrator | admin@admin.com | admin |
| Manager | manager@manager.com | admin |
| Executive | executive@executive.com | admin |
| User | user@user.com | admin |

## Student Portal

Login URL: `/student/login`
Dashboard URL: `/student/dashboard`

| Account | Login ID | Password |
| --- | --- | --- |
| Demo Student | student@student.com | student |
| Sample Student | sample.student@example.com | student |

## Trainer Portal

Login URL: `/trainer/login`
Dashboard URL: `/trainer/dashboard`

| Account | Login ID | Password |
| --- | --- | --- |
| Demo Trainer | trainer@trainer.com | trainer |
| Sample Trainer | sample.trainer@example.com | trainer |

## Center Portal

Login URL: `/center/login`
Dashboard URL: `/center/dashboard`

| Account | Login ID | Password |
| --- | --- | --- |
| Demo Center Manager | center@center.com | center |
| Sample Center Staff | staff.center@example.com | center |

Use the configured `APP_URL` before each path, for example `http://127.0.0.1:8000/login`.
