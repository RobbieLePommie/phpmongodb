 * @package PHPmongoDB
 * @version 2.0.0beta
 * @link

==============================================================================================================
 Introduction
==============================================================================================================
 A Tool available for administrative work of MongoDB over Web.

 This is a port of the orginal PHPmongoDB, adapted for the newer MongoDB drivers.

 Note: this is a beta version - there has been no attempt to optimise to suit new drivers.

 Provided As-Is with no guarantees. Not all features tested.

==============================================================================================================
Requirements
==============================================================================================================

1. Install the NEW MongoDB PHP driver (http://php.net/manual/en/set.mongodb.php)
2. Run Composer Install (or install PHP Mongo Library - see http://php.net/manual/en/mongodb.tutorial.library.php for instructions)
3. Open the config.php with your editor, change host, port, admins and so on As per your system. Default given below:
   -Server Setting
     'name' => "Localhost",
     'server'=>false,
     'host' => "127.0.0.1",
     'port'=>"27017",
     'timeout'=>0,
   - Make authentication = TRUE for using your MongoDB user and password.
   - Make authorization['readonly'] = TRUE for making your MongoDb readonly.
4. Visit the index.php in your browser, for example: http://localhost/phpmongodb
5. Login with admin username and password, which is set "admin" and "admin" as default

