# Task API Documentation

# List Tasks

**Endpoint**: `GET /api/v1/tasks`

Retrieves a paginated list of tasks.

## Authentication

Bearer Token required

## Query Parameters

| Parameter | Type    | Required | Default | Description      |
|-----------|---------|----------|---------|------------------|
| page      | integer | No       | 1       | Page number      |
| perPage   | integer | No       | 10      | Items per page   |
| sortBy    | string  | No       | id      | Field to sort by |
| sortType  | string  | No       | asc     | Sort direction   |

## Example Request

```http
GET /api/v1/tasks?perPage=10&page=1&sortBy=id&sortType=asc
Authorization: Bearer <your_token>
```

# Get Single Task

**Endpoint**: `GET /api/v1/tasks/{id}`

Retrieves a single task by ID.

## Authentication

Bearer Token required

## Example Request

```http
GET /api/v1/tasks/2
Authorization: Bearer <your_token>
```

# Create Task

**Endpoint**: `POST /api/v1/tasks`

Creates a new task.

## Authentication

Bearer Token required

## Request Body (form-data)

| Parameter      | Type    | Required | Default | Constraints                       |
|----------------|---------|----------|---------|-----------------------------------|
| board_id       | integer | No       | 1       |                                   |
| task_status_id | integer | No       | 1       |                                   |
| title          | string  | Yes      | -       |                                   |
| description    | string  | No       | -       |                                   |
| start_date     | string  | No       | -       | Format: Y-m-d H:i                 |
| due_date       | string  | No       | -       | Must be after or equal start_date |

## Example Request

```http
POST /api/v1/tasks
Authorization: Bearer <your_token>
Content-Type: multipart/form-data

title: GÖREV 1
start_date: 2025-04-06 15:00
due_date: 2025-04-06 18:00
board_id: 1
task_status_id: 1
description: GÖREV 1 AÇIKLAMASI
```

# Update Task

**Endpoint**: `PUT /api/v1/tasks/{id}`

Updates an existing task.

## Authentication

Bearer Token required

## Request Body (form-data)

| Parameter   | Type   | Required | Constraints                       |
|-------------|--------|----------|-----------------------------------|
| title       | string | No       |                                   |
| description | string | No       |                                   |
| start_date  | string | No       | Format: Y-m-d H:i                 |
| due_date    | string | No       | Must be after or equal start_date |

## Example Request

```http
PUT /api/v1/tasks/1
Authorization: Bearer <your_token>
Content-Type: multipart/form-data

title: Updated Task
due_date: 2025-04-06 18:30
description: Updated description
```

# Delete Task

**Endpoint**: `DELETE /api/v1/tasks/{id}`

Deletes a task with optional recovery.

## Authentication

Bearer Token required

## Query Parameters

| Parameter   | Type    | Required | Description          |
|-------------|---------|----------|----------------------|
| is_recovery | boolean | No       | Enable recovery mode |

## Example Request

```http
DELETE /api/v1/tasks/1?is_recovery=true
Authorization: Bearer <your_token>
```

# Change Task Status

**Endpoint**: `PATCH /api/v1/tasks/{id}/status-change`

Updates a task's status.

## Authentication

Bearer Token required

## Request Body (x-www-form-urlencoded)

| Parameter | Type    | Required | Description   |
|-----------|---------|----------|---------------|
| status_id | integer | Yes      | New status ID |

## Example Request

```http
PATCH /api/v1/tasks/2/status-change
Authorization: Bearer <your_token>
Content-Type: application/x-www-form-urlencoded

status_id=2
```
