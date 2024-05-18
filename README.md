Please configure your database as below:
DATABASE NAME = fyp_db
DATABASE USERNAME = fyp
USER PASSWORD = password
DB USED = MySQL

All Vue frontend are store in frontend folder.

The storage is use for file or image storing.

Models are created, use migrate to migrate the model.
CLI for migrate "php artisan migrate:fresh --seed"

Use the cli "php artisan schedule:work" to run the automated email.
The line above should be paired with "php artisan queue:work" for automated email, queue work is used so that it would redirect after process finished.
