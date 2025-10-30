# ARKFleet API Quick Reference

**Base URL**: `http://your-domain.com/api`  
**Authentication**: Not required (public API)  
**Format**: JSON

---

## Endpoints

### 1. Equipment List

```http
GET /api/equipments
```

**Recommended Query Parameters (human-readable):**

-   `project_code` - Filter by project code (e.g., 000H, 017C)
-   `status` - Filter by status: ACTIVE, IN-ACTIVE, SCRAP, SOLD (case-insensitive)
-   `plant_group` - Filter by plant group name (e.g., Excavator, Dump Truck)

**Legacy Parameters (still supported):**

-   `current_project_id` - Filter by project ID
-   `unitstatus_id` - Filter by status ID
-   `plant_group_id` - Filter by group ID

**Example:**

```bash
# All equipment
curl http://your-domain.com/api/equipments

# ACTIVE equipment (RECOMMENDED)
curl http://your-domain.com/api/equipments?status=ACTIVE

# Equipment in project 000H
curl http://your-domain.com/api/equipments?project_code=000H

# Active equipment in specific project
curl http://your-domain.com/api/equipments?project_code=017C&status=ACTIVE
```

---

### 2. Equipment Detail

```http
GET /api/equipments/by-unit/{unit_no}
```

**Example:**

```bash
curl http://your-domain.com/api/equipments/by-unit/EX-001
```

**Response:** Detailed equipment with nested relationships

---

### 3. Projects List

```http
GET /api/projects
```

**Example:**

```bash
curl http://your-domain.com/api/projects
```

**Response:** Array of active projects

---

## Quick Test

```bash
# Test API availability
curl -I http://your-domain.com/api/equipments

# Get first 5 equipment (pipe to jq for formatting)
curl http://your-domain.com/api/equipments | jq '.data[:5]'

# Count ACTIVE equipment (RECOMMENDED)
curl http://your-domain.com/api/equipments?status=ACTIVE | jq '.count'

# Get equipment by project code
curl http://your-domain.com/api/equipments?project_code=000H | jq

# Get SCRAP equipment
curl http://your-domain.com/api/equipments?status=SCRAP | jq '.count'

# Get specific equipment details
curl http://your-domain.com/api/equipments/by-unit/EX-001 | jq
```

---

## Common Status Values

Use with `status` parameter (case-insensitive):

| Status        | ID  | Description                      |
| ------------- | --- | -------------------------------- |
| **ACTIVE**    | 1   | Equipment operational and in use |
| **IN-ACTIVE** | 2   | Equipment not currently in use   |
| **SCRAP**     | 3   | Equipment scrapped/end of life   |
| **SOLD**      | 4   | Equipment sold to external party |

**Example:**

```bash
curl http://your-domain.com/api/equipments?status=ACTIVE
curl http://your-domain.com/api/equipments?status=scrap  # case-insensitive
```

---

## Response Structure

### Equipment List

```json
{
    "count": 2,
    "data": [
        {
            "id": 123,
            "unit_no": "EX-001",
            "description": "Excavator PC200-8",
            "unitstatus": "RFU",
            "project_code": "PRJ-2023-01"
            // ... 19 more fields
        }
    ]
}
```

### Equipment Detail

```json
{
    "id": 123,
    "unit_no": "EX-001",
    "description": "Excavator PC200-8",
    "project": {
        "id": 5,
        "project_code": "PRJ-2023-01",
        "bowheer": "PT Construction Company",
        "location": "Jakarta"
    },
    "unitstatus": {
        "id": 1,
        "name": "RFU"
    }
    // ... more nested relationships
}
```

---

## Error Responses

**404 Not Found:**

```json
{
    "message": "Equipment not found",
    "unit_no": "INVALID-001"
}
```

---

## Full Documentation

For complete documentation including:

-   All response fields
-   Code examples (JavaScript, PHP, Python)
-   Integration guides
-   Troubleshooting

See: **[docs/api-documentation.md](./api-documentation.md)**

---

**Last Updated**: 2025-10-30
