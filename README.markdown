# Mellt

## Description
[Mellt](http://mel.lt/) tests the strength of a password by calculating how long it would take to brute force it. Unlike most password strength checkers that just require one of each lowercase/uppercase/number/special char/at least 6 characters/etc, Mellt approaches the problem the same way a password cracker would, and returns a meaningful number you can use in determining the strength of a password. 

## Try it out

You can try the Javascript version of Mellt on the [Mellt homepage](http://mel.lt/).

## Usage

### PHP

	include('Mellt.class.php');
	$mellt = new Mellt();
	$daysToCrack = $mellt->CheckPassword('my password');
	
### Javascript
	
	<script src="Mellt.js"></script>
	<!-- Make sure common-passwords.js is included AFTER Mellt.js -->
	<script src="common-passwords.js"></script>
	<script>
	var mellt = new Mellt();
	var daysToCrack = mellt.CheckPassword('my password');
	</script>

### nodejs

	var mellt = require("./lib/Mellt");
	var daysToCrack = mellt.CheckPassword('my password');

### python

	import mellt
	m = mellt.Mellt()
	days_to_crack = m.check_password('my password')
	print str(days_to_crack) + ' days to crack'

### ruby

	require './Mellt.rb'
	m = Mellt.new()
	days_to_crack = m.check_password('my password')
	puts days_to_crack.to_s + " days to crack"

## Tips for passing Mellt

There are a couple easy things you can do to quickly increase the strength of your passwords in a way that Mellt recognizes.

- Increase the size of the character set you're using. In essence this means don't use just lower case and numbers. Adding uppercase and special characters (even spaces) will suddenly bump up the time to crack dramatically because the attacker now needs to search the extra characters at each position. In other words, adding a single punctuation mark to your password is like giving a power up to every other character in the password.

- Increase the number of characters you're using. The character set won't matter much if your password is less than 8 characters. One easy way to do this (and to satisfy the first requirement as well) is to make your password a short phrase, separating the words with some special character (spaces, dashes, periods, etc). As an added bonus, a short phrase will be easier for you to remember than 12 random characters.

## Security Q&A

#### Q: Those wacky crackers can see Mellt's code! They'll just use that to simplify their brute force attacks (eg: reversing the character sets)!

A: The benefit to the attacker of seeing the source to Mellt is negligible. No user is going to think to them self "I can save one character if I use z's instead of a's". Their favorite password will be banned because it's too weak and they'll pick something stronger (vs just adding a $ to the end) - that's the purpose of these scripts.

#### Q: You include the top 10,000 common passwords, won't people (and crackers) just use the 10,001st most common?

A: No, people don't work that way - they don't move down the list trying each one in turn. The purpose of banning the most common passwords is to prevent people from being lazy and using "password". Once you prevent that, you force them to be a little more creative and come up with something better.

#### Q: "[pass123$](http://pastebin.com/b79cJV5f)" isn't on the common list, but it's a terrible password! You should ban it!

A: No, if it's not on the list of 10,000 most common, it's probably not that common. And the attacker doesn't know that it's a bad password when s/he starts trying to break it, so they need to try all the combinations to get there. "pass123$" is not a good password, but it's not "[12345](http://www.youtube.com/watch?v=K95SXe3pZoY)" bad. It's up to you as the developer implementing Mellt to decide the level of security you want to enforce. "pass123$" takes about 2 days via brute force, so set your limit to be higher than that if you don't want it allowed.

#### Q: Why do I need this tool? I'm hashing my passwords / preventing multiple attempts per second / etc...

A: Mellt is assuming the attacker has your database of passwords. Of course you need to be hashing them (please tell me you're [not using MD5](http://codahale.com/how-to-safely-store-a-password/)) but even with a properly salted+hashed password table it can be brute forced pretty quickly if the passwords are weak. Mellt is just another piece of the pie in making the attacker's life more difficult.

## Credits

Much of the logic / concept behind Mellt is based on the description of the [TGP Password Strength Checker](http://www.hammerofgod.com/passwordcheck.aspx) by Timothy "Thor" Mullen.

The included common-passwords.txt contains the 10,000 most common passwords from [Mark Burnett's excellent password collection](http://xato.net/passwords/more-top-worst-passwords/).

The PHP and Javascript implementations were developed by [ravisorg](https://github.com/ravisorg).

The Node.js, python and ruby implementations were developed by [SeanJA](https://github.com/SeanJA).

## License

Mellt is licensed under the Modified BSD License (aka the 3 Clause BSD). Basically you can use it for any purpose, including commercial, so long as you leave the copyright notice intact and don't use my name or the names of any other contributors to promote products derived from Mellt.

	Copyright (c) 2012, ravisorg
	All rights reserved.
	
	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
	    * Redistributions of source code must retain the above copyright
	      notice, this list of conditions and the following disclaimer.
	    * Redistributions in binary form must reproduce the above copyright
	      notice, this list of conditions and the following disclaimer in the
	      documentation and/or other materials provided with the distribution.
	    * Neither the name of the Travis Richardson nor the names of its 
	      contributors may be used to endorse or promote products derived 
	      from this software without specific prior written permission.
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
	ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL TRAVIS RICHARDSON BE LIABLE FOR ANY
	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
