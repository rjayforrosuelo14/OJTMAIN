# OJT Management System - Login Credentials & Setup Guide

## ✅ Database Connected Successfully

Your application is now fully connected with the SQLite database.

### Database Status
- **Location**: `/database/database.sqlite`
- **Connection**: SQLite3
- **Status**: ✓ Active and Writable
- **Migrations**: 43 migrations executed successfully

---

## 🔐 Login Credentials

### Intern Account (Professional Dashboard)
```
Email: testintern@example.com
Password: password123
Type: Intern
```

**Features Available:**
- Professional dashboard with modern UI/UX
- Quick action buttons (Journal, DTR, Messages, Upload)
- Status overview cards (Phase, Attendance, Hours, Documents)
- Smart notifications system
- Phase progress timeline
- Responsive design (mobile, tablet, desktop)

### Admin Account
```
Email: rjay@gmail.com
Password: 12345678
Type: Administrator
```

**Features Available:**
- Admin dashboard
- Intern management
- Phase tracking and transitions
- Invitation link generation
- System configuration

---

## 🚀 How to Access

1. **Intern Login**: http://127.0.0.1:9002/intern/login
2. **Admin/Company Login**: http://127.0.0.1:9002/login
3. **Supervisor Login**: http://127.0.0.1:9002/supervisor/login

---

## 📋 System Configuration

### Session & Cache
- Session Driver: File-based
- Session Lifetime: 10,080 minutes (7 days)
- Cache Driver: File-based
- Database: SQLite

### Features Enabled
✓ Professional Dashboard
✓ Database Connection
✓ CSRF Token Protection
✓ Session Management
✓ File-based Caching
✓ Route Protection
✓ Error Handling

---

## 🛠️ Useful Commands

```bash
# Create test intern account
php artisan intern:create-test

# Clear application caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Access Laravel Tinker
php artisan tinker

# Run migrations
php artisan migrate

# View logs
tail -f storage/logs/laravel.log
```

---

## ✨ Dashboard Features

### Intern Professional Dashboard
1. **Welcome Header** - Personalized greeting with gradient background
2. **Quick Actions** - Journal, DTR, Messages, Upload buttons
3. **Status Cards** - Current phase, attendance, hours, documents
4. **Notifications** - Smart alerts for pending actions
5. **Feature Cards** - Detailed information for each module
6. **Phase Timeline** - Visual progress indicator through OJT phases

### Admin Dashboard
1. **Intern Management** - View and manage all interns
2. **Phase Transitions** - Control intern progression through phases
3. **Invitation System** - Generate and share invitation links
4. **Document Management** - Track document requests and submissions
5. **System Configuration** - Manage system settings

---

## 🔍 Troubleshooting

**Q: Connection refused error?**
A: Make sure the PHP server is running on port 9002

**Q: Database read-only error?**
A: Permissions have been fixed. If you encounter this again, run:
```bash
icacls "database" /grant Users:F /T
```

**Q: CSRF token errors?**
A: Sessions are configured to file-based with 7-day lifetime. Should be resolved.

**Q: Dashboard not displaying?**
A: Clear caches with: `php artisan view:clear`

---

## 📞 Next Steps

1. ✅ Log in with test intern account: testintern@example.com / password123
2. ✅ Verify professional dashboard displays correctly
3. ✅ Test navigation between different dashboard sections
4. ✅ Check admin dashboard functionality
5. ✅ Test phase transitions and document uploads

---

**Last Updated**: May 28, 2026
**Status**: ✅ Ready for Testing
