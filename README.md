---

## 🛠️ Architecture & Technical Highlights

### 1. Repository Pattern

To keep the controllers thin and decouple the data-access layer from business logic, this project implements the Repository Pattern:

*   **`StudentRepositoryInterface`**: Defines the contract for student data operations.

*   **`StudentRepository`**: Implements the contract using Eloquent ORM.

*   **Dependency Injection**: Bound in `AppServiceProvider` so the Laravel service container automatically injects the repository into `StudentController` via constructor injection. This makes the database layer easily swappable (e.g., if we ever migrate from SQLite to MySQL).

### 2. Role-Based Access Control (RBAC) via Gates

Authorization is strictly enforced using Laravel's native Gates:

*   **User Roles**: The `users` table contains a `role` column (defaulting to `'student'`). Current test roles include Admin (`Haider Ali`), Student (`Ibrahim`, `Test User`, `Ijaz`), and Teacher.

*   **Defined Gates** (in `AppServiceProvider`):

    *   `delete-student`: Restricts deletion exclusively to the `admin` role.
    *   `manage-students`: Restricts creation and editing to `admin` and `teacher` roles.

*   **Dual-Layer Enforcement**:

    *   *Backend Security:* Controller methods verify permissions using `Gate::denies()` and abort with a `403 Unauthorized` status if violated.
    *   *Frontend UI:* Cleanly shows or hides interactive elements in Blade views using `@can` and `@canany` directives.

### 3. Database, Factories & Seeders

*   **SQLite Database**: Self-contained, lightweight, and requires zero-config local setup.

*   **Seeding**: Includes `StudentFactory` and `StudentSeeder` to rapidly seed the database with 15 realistic student records using Laravel's `fake()` helpers for names, grades, and subjects.

### 4. Comprehensive Test Suite

Quality assurance was built-in from day one. The project boasts a suite of **40 passing tests** to prevent regressions:

*   Includes **7 dedicated feature tests** inside `tests/Feature/StudentManagementTest.php`.

*   Tests cover full CRUD operations, form validation errors, and strict role-based redirect/authorization blocks.