# VIBES Academy — Student Course Module

### Feature Specification Document

**Project:** VIBES Academy – Online Training & Learning Management Portal (LMS)
**Module:** Student Portal / Student Course Module
**Version:** 1.0
**Last updated:** 28 May 2026

---

## 1. Overview

The Student Course Module is the learner-facing portal of the VIBES Academy LMS. It governs the student's complete journey — from account activation through billing, to course consumption, assessments, attendance, and certification. Access is controlled, content is protected, and progress is tracked end-to-end across multiple clinics and courses.

**Design principles**

- Activation is tied to payment, not manual sign-up.
- Content is released progressively (day-wise / module-wise), never all at once.
- Video and learning content are protected against download and copying.
- Every student action (views, tests, attendance) is logged and reported automatically.
- Mobile and tablet friendly, with regional-language support.

---

## 2. Account Activation

| Feature | Description |
|---|---|
| Auto-activation via billing | Student portal account is created automatically through the billing/payment module — no manual registration. |
| Activation conditions | Login activates **only** after **100% fee payment**, **or** via optional **admin approval override**. |
| Auto-credential delivery | On account creation, login access is triggered automatically via SMS / Email. |

---

## 3. Login System

| Feature | Description |
|---|---|
| OTP-based login only | No password-based login at launch. |
| OTP via mobile number | One-time password sent to registered mobile. |
| OTP via email | One-time password sent to registered email ID. |

---

## 4. Course Access Logic

| Feature | Description |
|---|---|
| Enrolled-only visibility | Students see **only** the courses they are enrolled in. |
| Module-wise progression | Content opens in a timeline / module-wise format — not all unlocked together. |
| Sequential unlocking | Module 2 unlocks after Module 1 completion **or** trainer approval. |
| Day-wise visibility | Digital videos and PPTs become visible on a day-wise schedule (per working sheet). |
| Time-based release | Option to release content on a scheduled/time-based basis. |
| Course overview | Syllabus + schedule available to the student up front. |

---

## 5. Course Content Formats

The portal supports the following content types:

- Training videos
- Short videos / reels
- E-books / PDFs
- Mind maps
- Presentations (PPT)
- Audio files *(optional)*
- Downloadable notes *(optional, with download control)*
- **Regional-language option** for both text and video content (English + Bengali, Kannada, Telugu, Hindi)

---

## 6. Video & Content Security

Content protection is a critical requirement.

| Feature | Description |
|---|---|
| No downloads | Videos must not be downloadable. |
| Right-click / save disabled | Disable right-click and save options on content. |
| Watermarking | Watermarking preferred on video content. |
| Screen-recording protection | Screen-recording prevention where technically possible. |
| Streaming-only viewing | All video viewing is stream-based only. |

---

## 7. Assessment Module

**Test types available to students**

- Quick tests (e.g. 20-question)
- Full assessments
- Module-wise tests
- Tests embedded directly on a video (view + test with scoring)

**Student capabilities**

| Feature | Description |
|---|---|
| Attempt online tests | MCQ-based tests taken within the portal. |
| Instant scoring | Scores shown immediately on submission. |
| Test scores display | Portal shows scores for each test. |
| Completion % | Percentage of completion tracked. |
| Pass / fail status | Clear pass/fail outcome shown against defined pass marks. |
| Progress tracking | Assessment progress logged to student profile. |

---

## 8. Progress Tracking

The portal tracks the following per student:

- Content viewed
- Video watch completion %
- Assessments completed
- Attendance
- Pending modules

**Student dashboard displays:**

- Overall progress %
- Current module
- Upcoming assessments
- Automated student report on video viewing & test performance

---

## 9. Course Access Duration

| Feature | Description |
|---|---|
| Tenure-linked validity | Login validity is linked to course duration (e.g. 4-week course = 4 weeks access). |
| Auto-expiry | Access auto-expires after course completion. |
| Admin override | Admin can extend / override access duration when required. |

---

## 10. Certificate Module

| Feature | Description |
|---|---|
| Digital certificate generation | Certificate auto-generated on completion. |
| Downloadable / viewable | Student can download and view the certificate. |
| 1-year availability | Certificate remains accessible for 1 year after completion. |
| QR verification | Optional QR code on the certificate for verification. |

**Certificate contents:** Student name · Course name · Duration · Trainer name · QR code

---

## 11. Attendance & KYC

| Feature | Description |
|---|---|
| Attendance visibility | Student attendance recorded and visible in the portal. |
| KYC | KYC capture as part of the student record. |
| Biometric attendance | Attendance marked by trainer (biometric), reflected to the student profile. |

---

## 12. Notifications

The system sends notifications via **SMS**, **WhatsApp**, and **Email**:

- OTPs
- Assessment reminders
- Class reminders
- Attendance alerts
- Course completion alerts

Automated WhatsApp support is included for student communication.

---

## 13. Discussion / Support

| Feature | Description |
|---|---|
| Raise doubts | Students can raise questions / doubts within the portal. |
| Trainer replies | Trainers respond to student queries. |
| Automated WA support | Automated WhatsApp-based support channel. |

---

## 14. Platform & Device Requirements

- Mobile & tablet responsive
- Android-friendly
- Clinic tablets supported for in-class sessions

---

## 15. Security (applies to the Student Module)

- Role-based access control
- OTP authentication
- Content encryption
- Secure cloud hosting with SSL
- Backup system
- Admin audit logs

---

## Appendix A — Courses Available to Students

| # | Course | Duration | Theory + Practical | Fee Range (₹) |
|---|---|---|---|---|
| 1 | Advanced Laser (Hair Removal) Technician | 4 weeks | 1.5 + 2.5 wks | 40,000 – 60,000 |
| 2 | Skin & Aesthetic Therapist Certification (Advanced) | 8 weeks | 2.5 + 5.5 wks | 80,000 – 1,00,000 |
| 3 | Slimming & Body Contouring Specialist | 6 weeks | 2.0 + 4.0 wks | 60,000 – 75,000 |
| 4 | Clinic Management & Client Counsellor | 3 weeks | 1.0 + 2.0 wks | 30,000 – 45,000 |
| 5 | Certified Aesthetic & Slimming Expert (Flagship) | 12 weeks | 4.5 + 7.5 wks | 1,20,000 – 1,50,000 |

Each course is delivered module-wise with a mix of Theory, Practical, Live, and Assessment modules, ending in a final assessment and certificate on completion.

---

## Appendix B — Student Journey (Summary Flow)

1. **Billing** → fee collected at clinic/admin module.
2. **Auto-creation** → student account created; login sent via SMS/email.
3. **OTP login** → student logs in via mobile/email OTP.
4. **Course access** → enrolled course opens module-wise / day-wise.
5. **Learning** → streams protected videos, PPTs, e-books, mind maps (regional language optional).
6. **Assessment** → attempts MCQ tests; instant scoring; pass/fail.
7. **Tracking** → progress %, attendance, pending modules on dashboard.
8. **Completion** → access auto-expires; digital certificate generated (valid 1 year).
