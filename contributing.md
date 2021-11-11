<h1> Hi and welcome to he Todolist project </h1>

In order to contribute to the project, please follow the TDD process as follows :

1) open an issue on GitHub explaining the need and the general purpose of your development and follow this naming style :

<ul>
<li>feature</li>
<li>hotfix</li>
<li>update</li>
</ul>

For the branch prefix. Followed by a slash : "feature/"

Add the branch name in camel case : feature/userRoles

And then "Fixes" + the issue's id that your branch is fixing : feature/userRolesFixes#12

That way, we can instantly know which branch does what, and to which issue it is related.

2) Write the test for the feature before digging into the actual code, it should be located in test/AppBundle and follow the app architecture. Once your test fails, you're good to go =) Note that every return or throw should be tested, and that the code coverage should NOT go lower.


3) Code your feature following the Symfony practices, and do comment everything that is not native or can't be found in a bundle documentation.


4) Run your tests again and make everything green in PHPUnit.


5) Run the code coverage test with --code-coverage web/code-coverage and make sure that it still has 100%


6) Once it's all good, notify the project maintainer with a pull request demand and wait for approval.