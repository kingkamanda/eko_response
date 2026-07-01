# Eko Response — Step-by-step setup guide

This walks you through running the app locally on **Windows** (PowerShell) or
**macOS/Linux**. It assumes PHP 8 and MySQL/MariaDB are already installed.

---

## Step 0 — Get the latest code

If you cloned the repo, pull the current branch:

```bash
git pull origin claude/clever-ritchie-0ntfdx
```

If you downloaded a ZIP, re-download it so you have the latest files
(including `seed_demo.sql` and `upgrade.sql`). You should be working in a folder
that contains `index.php`, `classes/`, `admin/` directly — **not** inside an
older `project/` sub-folder.

---

## Step 1 — Find your MySQL password

The app connects as MySQL user `root`. You need the password **that user
actually has** on your machine. The simplest way to confirm it: open a terminal
and run

```bash
mysql -u root -p
```

Type a password. If you get the `mysql>` prompt, that password is correct — note
it. If you get `Access denied`, try the password you set when installing MySQL.

> The error `Access denied for user 'root'@'localhost' (using password: YES)`
> means the password you supplied is **wrong** — it is not an app bug. Keep
> trying the password you chose during MySQL installation.

If you have genuinely forgotten it, reset it (MySQL 8):

```sql
-- from a mysql session opened by an account that can log in
ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';
FLUSH PRIVILEGES;
```

After that, `root` / `root` will work and you can skip Step 4 (the app already
defaults to `root`/`root`).

---

## Step 2 — Create the database and load data

From the project root (the folder with `Eko Response.sql`):

```bash
mysql -u root -p < "Eko Response.sql"
```

This creates the `response` database and loads all reference data (states, LGAs,
emergency categories and the Lagos response units).

> If you previously imported a partial copy and see
> `ERROR 1050 ... Table 'admin' already exists`, drop the database first and
> import again:
>
> ```bash
> mysql -u root -p -e "DROP DATABASE IF EXISTS response;"
> mysql -u root -p < "Eko Response.sql"
> ```

---

## Step 3 — (Optional) demo account + already-existing data

```bash
mysql -u root -p response < seed_demo.sql
```

Gives you a ready login (`demo@ekoresponse.test` / `demo12345`) and a few sample
emergencies in locations that already have responders.

> Already have an older database with real data you don't want to lose? Run the
> upgrades instead of dropping — they add new columns/data without touching your
> existing rows:
>
> ```bash
> mysql -u root -p response < upgrade.sql    # map columns + extra categories
> mysql -u root -p response < upgrade2.sql   # agencies + emergency-type governance
> mysql -u root -p response < upgrade3.sql   # agency staff + response tracking
> mysql -u root -p response < upgrade4.sql   # severity + feedback + richer timeline
> ```
>
> (A fresh import of `Eko Response.sql` already includes everything.)

---

## Step 4 — Tell the app your password (only if it isn't `root`)

The app defaults to host `localhost`, db `response`, user `root`, password
`root`. If your MySQL password is different, set it in the **same terminal** you
will start PHP from.

Windows PowerShell:

```powershell
$env:DB_PASS = "your_mysql_password"
```

macOS / Linux:

```bash
export DB_PASS=your_mysql_password
```

(You can also just edit the `DBPASS` line in `classes/config.php` and
`admin/classes/config.php`.)

---

## Step 5 — Run the app

From the project root:

```bash
php -S localhost:8000
```

Open <http://localhost:8000>.

- **Register** a new account from the home page (or the Register button in the
  header), then sign in.
- **Report an emergency** from your dashboard or the "Report Emergency" menu —
  pick the type, choose state + LGA, and drop a pin on the map.
- **Admin**: <http://localhost:8000/admin/> — `biolanene@hotmail.com` / `12345`.

---

## What's new

- **Register button** on the home page and header for quick onboarding.
- **More emergency types**: Flood, Building Collapse, Road Accident, Gas Leak /
  Explosion, Kidnapping, Domestic Violence, Electrocution, Drowning, Civil
  Unrest — each routed to the right service (fire / police / medical).
- **Map pin-pointing**: the report form has an interactive map
  (OpenStreetMap/Leaflet — no API key required) plus a "Use my current location"
  button. The coordinates are saved with the report and shown as a "View on map"
  link on the user and admin dashboards.
- **Agencies & governed emergency types** (admin → *Emergency Types*): add/edit
  emergency types and set the responsible agency (e.g. Robbery → Police). Reports
  route to that agency's service automatically.
- **Reports** (admin → *Reports*): charts by type/agency/status/location with CSV
  export.
- **Hot zones**: auto-flagged areas by report density, on a map — for admins
  (admin → *Hot Zones*) and the public (*Hot Zones* in the menu / dashboard).
- **Public type requests**: users can propose a new emergency type
  (*Request Type* on the dashboard) that admins approve before it's reportable.
- **Agency portal** (`/agency/login.php`): agency admins manage staff and the
  emergency queue, assign responders; responders update status, attach photos,
  and file reports that build a tracking timeline. Responders can't see team size.
- **Reporter updates & images**: reporters open an incident (*Open* on the
  dashboard) to add details/photos to the timeline; incident images are viewable
  by all parties.
- **Severity & priority hot zones**: reports capture severity; hot zones list the
  **last 24 hours by severity** as priority and the **past 7 days** with detail.
- **Mandatory feedback**: after an emergency is resolved, the reporter must rate
  it before they can file another report.
