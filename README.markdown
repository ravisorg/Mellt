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
	
##License

Mellt is licensed under the Modified BSD License (aka the 3 Clause BSD). Basically you can use it for any purpose, including commercial, so long as you leave the copyright notice intact and don't use my name or the names of any other contributors to promote products derived from Mellt.

	Copyright (c) 2012, Travis Richardson
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