# Eko Response

A web application for reporting and coordinating emergencies in Lagos State,
Nigeria. Members of the public register, sign in, and report an incident
(medical, fire, accident, theft/crime, ambulance). Each report is tied to the
user who filed it and to a location (state + local government area), then
routed to the relevant response units (hospitals, fire stations, police units).
Administrators manage users and emergencies from a dedicated dashboard.

## Tech stack

- PHP 8 (plain PHP, no framework)
- MySQL / MariaDB (via PDO)
- Bootstrap 5 + jQuery on the front end

## Project layout

```
.
├── index.php              Public landing page
├── login_signup.php       Combined sign in / sign up
├── emergency_form.php     Report an emergency (requires login)
├── user_dashboard.php     Signed-in user's dashboard
├── hospital.php / fire.php / police.php   Response-unit result pages
├── server.php             AJAX endpoint: LGAs for a selected state
├── classes/               Domain classes (Db, User, Incident, State)
├── process/               Form handlers (login, signup, incident, profile)
├── partials/              Shared header/footer/logo includes
├── admin/                 Admin area (login, dashboard, manage emergencies)
├── assets/ , static/      CSS, JS, images, Bootstrap
├── uploads/               User profile pictures
├── incident_media/        Uploaded incident photos/videos
├── admin/                 Super-admin area (users, types, reports, hot zones)
├── agency/                Agency staff portal (admins, employees, responders)
├── Eko Response.sql       Database schema + seed data
├── seed_demo.sql          Optional demo public user + sample emergencies
├── seed_staff.sql         Optional demo agency staff accounts
├── upgrade.sql            Schema upgrade: map columns + extra categories
├── upgrade2.sql           Schema upgrade: agencies + emergency-type governance
├── upgrade3.sql           Schema upgrade: agency staff + response tracking
├── upgrade4.sql           Schema upgrade: severity + feedback + timeline
├── SETUP.md               Detailed step-by-step setup guide
├── SEED_ACCOUNTS.md       All seeded logins + how work flows between roles
└── Eko Response ERD.png   Entity-relationship diagram
```

## Roles & portals

| Portal | Who | Where |
|--------|-----|-------|
| Public site | Anyone / registered users | `/` |
| Super admin | Platform owner | `/admin/` |
| Agency portal | Agency admins, employees, responders | `/agency/login.php` |

Public users report emergencies (pinning the location on a map) and can request
new emergency types. Each type has a **responsible agency**; new reports flow to
that agency's queue, where an **agency admin/employee** assigns a **responder**,
who updates status and files response reports that build a tracking timeline.
Repeatedly affected areas surface automatically as **hot zones**.

See **[SEED_ACCOUNTS.md](SEED_ACCOUNTS.md)** for every seeded login.

> New here or hitting a database error? Follow **[SETUP.md](SETUP.md)** for a
> detailed, OS-specific walkthrough.

## Getting started

The app's defaults (host `localhost`, database `response`, user `root`,
password `root`) match a standard local MySQL install, so on most setups you
only need to import the database and start the server.

1. **Import the database.** `Eko Response.sql` creates the `response` database
   and loads all reference data (states, LGAs, categories, and the Lagos
   response units), so you can pipe it straight into MySQL:

   ```bash
   mysql -u root -p < "Eko Response.sql"
   ```

2. **(Optional) Load demo data** — a ready-to-use account plus sample
   emergencies in locations that already have responders:

   ```bash
   mysql -u root -p response < seed_demo.sql
   ```

3. **Set your MySQL password if it isn't `root`.** Connection settings are read
   from environment variables; set them in the **same terminal** you start PHP
   from.

   macOS / Linux:

   ```bash
   export DB_PASS=your_mysql_password
   ```

   Windows PowerShell:

   ```powershell
   $env:DB_PASS = "your_mysql_password"
   ```

   The other variables (`DB_HOST`, `DB_NAME`, `DB_USER`) work the same way.
   Alternatively, edit the defaults directly in `classes/config.php` and
   `admin/classes/config.php`.

4. **Run it** with the built-in PHP server from the project root:

   ```bash
   php -S localhost:8000
   ```

   Then open <http://localhost:8000>.

## Accounts

**Administrator** (ships with the main schema) — sign in at
<http://localhost:8000/admin/>:

- Email: `biolanene@hotmail.com`
- Password: `12345`

**Demo user** (only after running `seed_demo.sql`) — sign in from the home page:

- Email: `demo@ekoresponse.test`
- Password: `demo12345`

## Troubleshooting

- **`Access denied for user 'root'@'localhost'` / "Database connection error"** —
  your MySQL password doesn't match. Set `DB_PASS` (see step 3) to the password
  you use for MySQL, then restart `php -S`.
- **`ERROR 1050 ... Table 'admin' already exists`** on import — the database was
  partly imported before. Drop it and re-import for a clean load:

  ```bash
  mysql -u root -p -e "DROP DATABASE IF EXISTS response;"
  mysql -u root -p < "Eko Response.sql"
  ```
- **`seed_demo.sql ... does not exist`** — you're on an older copy of the repo.
  Pull the latest branch (or re-download) so the file is present.

## How emergencies are logged across locations

When a signed-in user reports an emergency they pick a **state** and a
**local government area** (the LGA list loads via AJAX for the chosen state),
plus an address. The report is stored against the user and that LGA.

On the results page the app looks for response units in the exact LGA. If none
are registered there yet, it automatically widens the search to **every unit in
the same state** and flags that it is showing the nearest available responders,
so a report is never a dead end. If a state has no registered units at all, the
page falls back to the national emergency line (112).
