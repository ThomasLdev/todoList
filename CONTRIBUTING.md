In order to contribute to the project, please follow the TDD process as follows :

<h2>1) Which Branch To Work On ?</h2>

Open an issue on GitHub explaining the need and the general purpose of your development and follow this naming style :

<ul>
<li>feature</li>
<li>hotfix</li>
<li>update</li>
</ul>

For the branch prefix. Followed by a slash : "feature/"

Add the branch name in camel case : feature/userRoles

And then "Fixes" + the issue's id that your branch is fixing : 
```
feature/userRolesFixes#12
```
That way, we can instantly know which branch does what, and to which issue it is related.

<h2>2) Where to start ?</h2>

1) Write the test for the feature before digging into the actual code, it should be located in tests/ and follow the app architecture. Once your test fails, you're good to go =) Note that every return or throw should be tested, and that the code coverage should NOT go lower.


2) Code your feature following the Symfony practices, and do comment everything that is not native or can't be found in a bundle documentation.


3) Run your tests again and make everything green in PHPUnit with the command :
```
vendor/bin/phpunit (--filter YourMethodOrController for individual test)
```

4) All green ?Run the code coverage  
```
XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-text . 
```
And make sure that it still has the same level as before (90%+)


5) Once it's all good (meaning all green and 90% coverage), notify the project maintainer with a pull request demand and wait for approval.

<h2>3) How to code ?</h2>

This project follows the PSR-2 standard and the PSR-4 autoload standards.