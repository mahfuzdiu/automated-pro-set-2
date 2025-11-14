## Project and Task Listing Assignment

### Run Using Docker 
1. Git pull project and go inside project-management-system directory
```angular2html
git pull git@github.com:mahfuzdiu/automated-pro-set-2.git
```
2. Setup SMTP (mailchimp preferred) for testing in .env.example
```angular2html
MAIL_USERNAME=mailtrap_username
MAIL_PASSWORD=mailtrap_password
```

3. Run below docker command. Check docker logs to finish up the build process. When finished, visit ```http://localhost:8000/``` to check if the project is up and running
```angular2html
docker compose up -d
```

4. Run following command before testing email notification on ```/bookings/{{booking_id}}/confirm``` . This route is for admin only 
```angular2html
docker compose exec app php artisan queue:work
```
