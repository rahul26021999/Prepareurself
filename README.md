# Prepareurself
Prepareurself is a platform which provides multiple resources for the most in-demand technical skills like Android, Java, Laravel, flutter, etc. We aim to prepare students for their internships and job so that they can learn skills, develop projects and crack interviews.
<br>
<b>Maximum Resources</b>
<br>
Our content writers are updating data with the most genuine and best resources in form of theory and videos from all over the internet.
<br>
<b>Projects</b>
<br>
We have categorised the projects in 3 layers and students can easily hop on the best projects to start with.
<br>
<b>Quizzes</b>
<br>
Learning is important. But testing makes your realise what you could understand and what one needs to work on again.
<br>
It one of the most incredible features of live quizzes that lets you test your command on skills and the leaderboard shows where you stand in crowd.

### Setup Prepareuself

<p><b>Prerequists</b></p>
<ol>
	<li>Install lamp / Xampp</li>
	<li>Install composer</li>
	<li>Install Mysql Database and Mysql Database Client</li>
	<li>Install PHP</li>
</ol>
<p><b>Step to Run the Project</b></p>
<ol>
	<li>Clone Project </li>
	<li>Rename .env.example to .env</li>
	<li>Run composer Install</li>
	<li>Go to <code>http://locahost:8000</code> It should redirect you to Prepareurself Playstore Application</li>
	<li>Create a database name "prepareurself"</li>
	<li>Replace Mysql Credentials with yours in .env file </li>
	<li>Replace Mailtrap Credentials in .env for Testing Mails</li>
	<li>Now run <code>php artisan migrate</code> on Terminal to Migrate Tables into the Database</li>
	<li>Now run <code>php artisan make:superUser</code> to create a super user for the Admin Panel.This will create a default superadmin with the below given credentials <br> <b>Email</b> : rahul26021999@gmail.com <br><b>Password</b> : ohmygod </li>
	<li>Now go to <code>http://localhost:8000/admin/auth/login</code>. Where u have to login using the above credentials to enter into Admin Dashboad</li>
</ol>
<p><b>How to use Prepareurself APIs</b></p>
<ol>
	<li>Login into Admin Panel.</li>
	<li>You should be logged in to Admin Dashboard to use APIs Documentations.</li>
	<li>Click on API Documentation button on Admin Dashboard to See the API Documentation or diectly go to <code>http://localhost:8000/admin/api/documentation</code>.</li>
	<li>To test the API's you need to generate a JWT token. You will get a default JWT token from the very first user in the application from the Admin Panel. If there is 0 users then go to APIs documentation create a user. Then check dashbaord for JWT token or you will get it in API Response also. </li>
	<li>Now you can test any api using that JWT token.</li>
</ol>
<p><b>Explore Admin Dashboard</b></p>
<ol>
	<li>On the Left hand side you will see the dashboard menu and on right hand side you will see the overoll numbers of Resources,Project,Users and all</li>
	<li><b>Manage Users : </b> Here you can see the list of users and Details of each and every user. You can block a user and unblock a user from here.</li>
	<li><b>Question Bank :</b> Here you can add new Questions and Make Quiz for a particular Tech <b>(In Development)</b></li>
	<li><b>Course :</b> Here you can add a new Course,edit course and can see all the courses. You can change the sequence of the courses to be displayed in the android application. You can publish a course and unpublish a course also where publish courses can be seen only on the andorid applications. You can go to the topics , project and resources of a particular course. You can also delete a course from here but you should be a superadmin.</li>
	<li><b>Topics :</b>Here you can add a topic , edit a topic , delete a topic and can see all the topics for a particular course.</li>
	<li><b>Projects :</b> Here you can add, edit and delete a project. You can see the list of projects also with detials.</li>
	<li><b>Resources :</b>Here you can add, edit, delete and list all the resources.</li>
	<li><b>Send Email: </b> From Here you can send specific emails like course added, projects added, etc and  custom Emails to your registered users. You can also save a custom Email and can see the previous emails sent by Admins and the no. of users got received that emails</li>
	<li><b>Android Notification : You can Send a android notification to your registered used. You can add title, desc, image, and can specific that action on the notification also.</b></li>
	<li><b>Banner : </b>From here you can add ,edit , delele , publish , unpublish banners in your android application.</li>
	<li><b>User Feedback : </b>You will get the list for feedbacks sent by Users through android application.</li>
	<li><b>Manage CMS : </b>You can add some more admins from here. This will sent a invite to be a admin. This feature is accessible for superadmin only <b>(In Development)</b></li>
</ol>

<p><b>Dashboard Preview</b></p>
<ul>
	<li><a href="https://user-images.githubusercontent.com/35486010/122549421-14365c00-d050-11eb-8ac1-e126321b5234.png">Admin Dashboard</a></li>
	<li><a href="https://user-images.githubusercontent.com/35486010/122549680-65dee680-d050-11eb-8907-dab6f442c522.png">Send Custom Emails</a></li>
	<li><a href="https://user-images.githubusercontent.com/35486010/122549837-8dce4a00-d050-11eb-9f7b-fcf9457aa01d.png">Send Android Notifications</a></li>
	<li><a href="https://user-images.githubusercontent.com/35486010/122549939-ab031880-d050-11eb-8d08-c0b02fb36c2b.png">Courses Menu</a></li>
</ul>