# rest-api-tasks
Laravel Version : 11.9

git clone https://github.com/neerajgangoti/rest-api-tasks.git
 
1) Rename .env.example with env
2) composer install
3) php artisan migrate
4) php artisan optimize:clear
5) php artisan make:job ProcessTask
6) Install package
composer require illuminate/bus
7) php artisan make:controller API/TaskController
8) Define Method Inside them
9) Start queue worker
php artisan queue:work


    API              |  Endpoint                   |  Method   |   Result
1. Submit Task       | /api/tasks                  | POST      | Create task, return task_id
2. Check Task Status | /api/tasks/{task_id}/status | GET       | Check if task is pending, processing, completed, failed
3. Get Task Result   | /api/tasks/{task_id}/result   | GET       | Fetch result after completion
4. Register User     | /api/auth/register           | POST     | Register User
5. Login user        | /api/auth/login              | POST     | Return Token
