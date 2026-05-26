# Portal Login Credentials

All portals are available on the local development server at `http://127.0.0.1:8000`.

---

## 1. Admin Portal (Web Guard)

Uses the standard `web` guard with `App\Models\User`.

| URL | Email | Password | Role |
|-----|-------|----------|------|
| `http://127.0.0.1:8000/login` | admin@gmail.com | admin | Super Admin |
| `http://127.0.0.1:8000/login` | admin@admin.com | admin | Administrator |
| `http://127.0.0.1:8000/login` | manager@manager.com | admin | Manager |
| `http://127.0.0.1:8000/login` | executive@executive.com | admin | Executive |
| `http://127.0.0.1:8000/login` | user@user.com | admin | User |

After login → redirects to `http://127.0.0.1:8000/admin/dashboard`

---

## 2. Student Portal (student guard)

Uses the `student` guard with `Modules\Student\Models\Student`.

| URL | Email | Password | Enrollment |
|-----|-------|----------|------------|
| `http://127.0.0.1:8000/student/login` | student@student.com | student | STU100001 |
| `http://127.0.0.1:8000/student/login` | sample.student@example.com | student | STU100002 |
| `http://127.0.0.1:8000/student/login` | priya.sharma@example.com | student | STU100003 |

After login → redirects to `http://127.0.0.1:8000/student/dashboard`

---

## 3. Trainer Portal (trainer guard)

Uses the `trainer` guard with `Modules\Trainer\Models\Trainer`.

| URL | Email | Password | Specialization |
|-----|-------|----------|----------------|
| `http://127.0.0.1:8000/trainer/login` | trainer@trainer.com | trainer | Wellness Coaching |
| `http://127.0.0.1:8000/trainer/login` | sample.trainer@example.com | trainer | Fitness Training |
| `http://127.0.0.1:8000/trainer/login` | rahul.verma@example.com | trainer | Physiotherapy |

After login → redirects to `http://127.0.0.1:8000/trainer/dashboard`

---

## 4. Center Portal (center guard)

Uses the `center` guard with `Modules\Center\Models\CenterUser`.

> **Note:** Center users are staff accounts linked to a center record.
> Run `CenterDatabaseSeeder` first so centers exist before seeding center users.

| URL | Email | Password | Role |
|-----|-------|----------|------|
| `http://127.0.0.1:8000/center/login` | center@center.com | center | Manager |
| `http://127.0.0.1:8000/center/login` | receptionist@center.com | center | Receptionist |
| `http://127.0.0.1:8000/center/login` | staff@center.com | center | Staff |

After login → redirects to `http://127.0.0.1:8000/center/dashboard`

---

## Seeding Commands

Run all seeders at once:
```bash
php artisan db:seed
```

Or run individual module seeders:
```bash
# Admin users + roles
php artisan db:seed --class="Database\\Seeders\\AuthTableSeeder"

# Students
php artisan db:seed --class="Modules\\Student\\database\\seeders\\StudentDatabaseSeeder"

# Trainers
php artisan db:seed --class="Modules\\Trainer\\database\\seeders\\TrainerDatabaseSeeder"

# Centers (countries, states, centers, center users)
php artisan db:seed --class="Modules\\Center\\database\\seeders\\CenterDatabaseSeeder"
```

---

## Guard Summary

| Guard | Model | Table | Login URL |
|-------|-------|-------|-----------|
| `web` | `App\Models\User` | `users` | `/login` |
| `student` | `Modules\Student\Models\Student` | `students` | `/student/login` |
| `trainer` | `Modules\Trainer\Models\Trainer` | `trainers` | `/trainer/login` |
| `center` | `Modules\Center\Models\CenterUser` | `center_users` | `/center/login` |
