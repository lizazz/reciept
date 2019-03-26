Demo of admin panel you may see there http://lagarto.devtestnet.com/admin
For install new project, please:
1) clone project from gitlab
	git clone http://gitlab.tsn-media.com/tsn-media/create-admin-panel-fo-future-projects.git -b 233137-create-admin-panel-fo-future-projects-laravel-55
2) In root folder will be install.txt, open it and continue installing according the instruction
3) Login to admin controll panel (Admin CP) as user with admin permission. Url is Your_domain_name/admin. During installation in system was created first admin account:
	login: admin@example.com
	pass: .xHfBg>M;>2!f#U
You may add new user or change password for exist one in user`s settings
Admin control panel sections
	1.Dashboard
Dashboard is a empty page with greeting
	2. Pages
Pages — allow create/edit and delete pages for client side. After creating of page, it will avaibles Your_domain_name/%url%, where url — you set when created page
All pages — it is real files, which you can find in Root_Directory/storage/app/public/pages. You may edit it as in admin CP, as in you favorite IDE.
Pages have rich editor, which support base functionality of Blade tamplate`s syntacsys. 
Pages support layouts. You may find their in  Root_Directory/storage/app/public/pages/layouts
Page has code section — it for php code. If you need do some php code before showing page on client side (for example read data from database and save their in blade variables) you should create function with name «onStart», also you may call other function from this function
Checkbox «ishidden» used for enabling maintenance mode for current page.
Button «View page» open saved page in new browser tab
	3.Media
Media show all download images. You may show, add and delete images and edit internal image name. All images are in Root_Directory/storage/app/public/media
	4.Users and User`s roles
In this section you may see, create, edit, disable and delete existing users (but not himself)
Roles have select — admin or not, only users with admin role can enter to admin CP.
On User edit page has «Login as user» button, it allow login to client side as current user
	5.Languages and translations
This section allow see, create, edit and delete supported languages and translation`s files for these languages.
All languages are folder in Root_Directory/resources/lang folder and translation files are just files in current language folder
!!Be careful when edit system language files it can crash all project!!
	6.Settings
In settings you may set sitename, timezone. These settings not change basic laravel setting and if you need to use admin CP setting you should use Setting::get('%settings name%');
Maintenance setting enable or disable maintenance mode for all site, if meintenance time bigger then now — user will see timer till end  maintenance mode
