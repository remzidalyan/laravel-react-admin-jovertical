# Laravel React Task Management System

## Overview

This system provides a comprehensive task management solution with:

- Dashboard for task operations (CRUD)
- Task creation/editing forms
- Kanban board visualization
- Drag-and-drop functionality
- Real-time notifications
- Automated task scheduling

## Key Features

### 1. Task Management Module

**Components:**

- Task creation form (title, description, assignee, dates)
- Task listing with pagination
- Detailed task view
- Edit/Delete functionality

**Technical Implementation:**

- Laravel REST API backend
- React frontend with Axios for API calls
- Form validation on both client and server sides
- Soft delete functionality with recovery option

### 2. Kanban Board

**Functionality:**

- Visual status tracking (Todo/In Progress/Done)
- Drag-and-drop status updates
- Real-time board refresh
- Column customization

**Technical Implementation:**

- React Beautiful DnD library
- Custom status transition logic
- Optimistic UI updates
- WebSocket integration for real-time sync

### 3. Notification System

**Features:**

- Email notifications on:
    - Task assignment
    - Status changes

**Technical Implementation:**

- Laravel Notifications
- Queue workers for async delivery

## Test Cases Overview

### Task Management

| Test Case                 | Objective                                | Verification Steps                                                                                                                                                           |
|---------------------------|------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **TC-1: Task Creation**   | Verify successful task creation          | 1. Open task creation form<br>2. Fill required fields (title)<br>3. Submit the form<br>4. Verify record creation in database<br>5. Confirm new task appears in the task list |
| **TC-2: Task Update**     | Ensure proper task editing functionality | 1. Select a task from the list<br>2. Modify title/description/status<br>3. Save changes<br>4. Verify updated details on task view page<br>5. Check database record updates   |
| **TC-3: Task Deletion**   | Test task removal process                | 1. Select task to delete<br>2. Click delete button<br>3. Confirm deletion dialog<br>4. Verify removal from task list<br>5. Check `deleted_at` timestamp in DB                |
| **TC-4: Pagination**      | Validate task list navigation            | 1. Create 10+ test tasks<br>2. Set pagination to 5 items/page<br>3. Navigate between pages<br>4. Change "Items per page" value<br>5. Verify filtered results pagination      |
| **TC-4.1: Task All List** | Ensure all tasks are displayed           | 1. Create 10+ test tasks<br>2. Verify all tasks are displayed on one page<br>3. Check for performance issues with large datasets                                             | 

### Kanban Board

| Test Case               | Objective                   | Verification Steps                                                                                                                                                                                  |
|-------------------------|-----------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **TC-5: Drag-and-Drop** | Verify status change via UI | 1. Drag task from "Pending" column<br>2. Drop into "In Progress" column<br>3. Verify visual transition animation<br>4. Confirm status update in database<br>5. Check for status change notification |

### Real-Time Features

| Test Case               | Objective                       | Verification Steps                                                                                                                       |
|-------------------------|---------------------------------|------------------------------------------------------------------------------------------------------------------------------------------|
| **TC-6: Notifications** | Test alert system functionality | 1. Change task status<br>2. Check in-app database                                                                                        |
| **TC-7: Auto Updates**  | Validate scheduled transitions  | 1. Set task start date to future<br>2. Wait for scheduled time<br>3. Verify automatic status change<br>4. Check associated notifications |

### Performance

| Test Case         | Objective                 | Verification Steps                                                                                                               |
|-------------------|---------------------------|----------------------------------------------------------------------------------------------------------------------------------|
| **TC-8: Caching** | Verify query optimization | 1. Request task list<br>2. Check Redis cache hits<br>3. Verify 60-second cache duration<br>4. Test cache invalidation on updates |

## API Integration

### 📌 API Endpoints

The following endpoints are used in this module:

| Method | Endpoint                    | Description                        |
|--------|-----------------------------|------------------------------------|
| GET    | `/api/v1/tasks`             | Retrieve paginated task list       |
| POST   | `/api/v1/tasks`             | Create new task                    |
| PUT    | `/api/v1/tasks/{id}`        | Update existing task               |
| DELETE | `/api/v1/tasks/{id}`        | Delete task (with recovery option) |
| PATCH  | `/api/v1/tasks/{id}/status` | Change task status                 |
| GET    | `/api/v1/tasks/all`         | Get tasks list                     |

**Full API Reference**: See detailed documentation in [api-doc.md](./api-doc.md)

### Usage Example

```javascript
// Fetching tasks
const response = await axios.get('/api/v1/tasks', {
  params: {
    perPage: 10,
  },
  headers: {
    'Authorization': `Bearer ${token}`
  }
});
