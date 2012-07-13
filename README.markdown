#Mellt

##Description
[Mellt](https://github.com/ravisorg/Mellt) tests the strength of a password by calculating how long it would take to brute force it. Unlike most password strength checkers that just require one of each lowercase/uppercase/number/special char/at least 6 characters/etc, Mellt approaches the problem the same way a password cracker would, and returns a meaningful number you can use in determining the strength of a password. 

##Credits

Much of the logic / concept behind Mellt is based on the description of the [TGP Password Strength Checker](http://www.hammerofgod.com/passwordcheck.aspx) by Timothy "Thor" Mullen.

The included common-passwords.txt contains the 10,000 most common passwords from [Mark Burnett's excellent password collection](http://xato.net/passwords/more-top-worst-passwords/).

##Usage

	include('Mellt.class.php');
	$mellt = new Mellt();
	$daysToCrack = $mellt->CheckPassword('my password');