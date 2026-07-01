# Eko Response — seed accounts & data

All the login accounts that ship with the database, and how to load them.

## Load the data

```bash
# 1. Schema + reference data + Lagos response units (also creates the DB)
mysql -u root -p < "Eko Response.sql"

# 2. Optional demo data
mysql -u root -p response < seed_demo.sql     # a public user + sample emergencies
mysql -u root -p response < seed_staff.sql    # agency staff accounts (below)
```

> Upgrading an existing database instead of a fresh import? Run the `upgrade*.sql`
> files in order (`upgrade.sql`, `upgrade2.sql`, `upgrade3.sql`) before the seed
> files. A fresh `Eko Response.sql` import already contains every table.

## Accounts

### Super administrator — `/admin/`
Manages the whole platform: users, emergencies, emergency types & responsible
agencies, reports, and hot zones.

| Email | Password |
|-------|----------|
| `biolanene@hotmail.com` | `12345` |

### Public user — home page login (`login_signup.php`)
Reports emergencies, sees hot zones, requests new emergency types.
*(Requires `seed_demo.sql`.)*

| Email | Password |
|-------|----------|
| `demo@ekoresponse.test` | `demo12345` |

You can also just click **Register** on the home page to create your own.

### Agency staff — `/agency/login.php`
Unified login; the portal routes each person by role. **Every account below uses
the password `staff12345`.** *(Requires `seed_staff.sql`.)*

| Agency | Role | Email |
|--------|------|-------|
| Nigeria Police Force | Agency admin | `police.admin@ekoresponse.test` |
| Nigeria Police Force | Employee | `police.employee@ekoresponse.test` |
| Nigeria Police Force | Responder | `police.responder@ekoresponse.test` |
| Lagos Fire & Rescue | Agency admin | `fire.admin@ekoresponse.test` |
| Lagos Fire & Rescue | Responder | `fire.responder@ekoresponse.test` |
| LASAMBUS (Medical) | Agency admin | `medical.admin@ekoresponse.test` |
| LASAMBUS (Medical) | Responder | `medical.responder@ekoresponse.test` |
| Platform (no agency) | Platform manager | `platform.manager@ekoresponse.test` |
| Platform (no agency) | Platform employee | `platform.employee@ekoresponse.test` |

## Roles at a glance

- **Super admin** — platform owner (`/admin/`): onboards agencies (by state),
  emergency types, platform staff; generates reports; flags incidents.
- **Platform manager/employee** — cross-agency oversight in the staff portal;
  reviews and flags unresponded/unresolved incidents.
- **Agency admin** — manages their agency's staff and emergency queue; assigns
  responders; sees agency hot zones.
- **Employee** — views the agency queue, assigns responders, updates status.
- **Responder** — sees their assigned emergencies, updates status, files response
  reports, and the tracking timeline.

## How work flows

1. A public user reports an emergency and pins the location.
2. It is attached to the **responsible agency** of the chosen emergency type.
3. That agency's admin/employees see it, **assign a responder**, and set status.
4. The **responder** works it: records updates (enroute → resolved) and notes,
   which build the **tracking timeline**.
5. Repeated reports in an area automatically surface it as a **hot zone**.
