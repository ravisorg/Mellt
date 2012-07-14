<?php

/**
 * Mellt
 *
 * Tests the strength of a password by calculating how long it would take to
 * brute force it.
 *
 * @version 0.1.0
 * @link http://mel.lt/ The homepage for this script.
 * @link http://www.hammerofgod.com/passwordcheck.aspx Much of this is based 
 * on the description of Thor's Godly Privacy password strength checker, 
 * however the actual code below is all my own.
 * @link http://xato.net/passwords/more-top-worst-passwords/ The included
 * common passwords list is from Mark Burnett's password collection (which
 * is excellent). You can of course use your own password file instead.
 */
class Mellt {

	/**
	 * @var integer $HashesPerSecond The number of attempts per second you expect
	 * an attacker to be able to attempt. Set to 1 billion by default.
	 */
	public $HashesPerSecond = 1000000000;

	/**
	 * @var string $CommonPasswordFile The path to a text file containing common
	 * passwords (one per line, all lower case) to check against. By default set 
	 * to point to the file included with PasswordStrength. Set this to null to 
	 * skip checking common passwords. 
	 */
	public $CommonPasswordFile = 'common-passwords.txt';

	/**
	 * @var array $CharacterSets An array of strings, each string containing a
	 * character set. These should proceed in the order of simplest (0-9) to most
	 * complex (all characters). More complex = more characters.
	 */
	public $CharacterSets = array(
		// We're making some guesses here about human nature (again much of this is 
		// based on the TGP password strength checker, and Timothy "Thor" Mullen 
		// deserves the credit for the thinking behind this). Basically we're combining 
		// what we know about users (SHIFT+numbers are more common than other 
		// punctuation for example) combined with how an attacker will attack a 
		// password (most common letters first, expanding outwards).
		//
		// If you want to support passwords that use non-english characters, and
		// your attacker knows this (for example, a Russian site would be expected
		// to contain passwords in Russian characters) add your characters to one of
		// the sets below, or create new sets and insert them in the right places.
		"0123456789",
		"abcdefghijklmnopqrstuvwxyz",
		"abcdefghijklmnopqrstuvwxyz0123456789",
		"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
		"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
		"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+",
		"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+[]\"{}|;':,./<>?`~",
	);

	/**
	 * Tests password strength by simulating how long it would take a cracker to
	 * brute force your password. 
	 *
	 * Also optionally tests against a list of common passwords (contained in an 
	 * external file) to weed out things like "password", which from a pure brute
	 * force perspective would be harder to break if it wasn't so common.
	 *
	 * The character sets being used in this checker assume English (ASCII) 
	 * characters (no umlauts for example). If you run a non-english site, and you 
	 * suspect the crackers will realize this, you may want to modify the 
	 * character set to include the characters in your language.
	 *
	 * @param string $password The password to test the strength of
	 * @return integer Returns an integer specifying how many days it would take 
	 * to brute force the password (at 1 billion checks a second) or -1 to 
	 * indicate the password was found in the common passwords file. Obviously if 
	 * they don't have direct access to the hashed passwords this time would be 
	 * longer, and even then most computers (at the time of this writing) won't be 
	 * able to test 1 billion hashes a second, but this function measures worst 
	 * case scenario, so... I would recommend you require at least 30 days to brute 
	 * force a password, obviously more if you're a bank or other secure system.
	 * @throws Exception If an error is encountered.
	 */
	public function CheckPassword($password) {

		// First check passwords in the common password file if available.
		// We do this because "password" takes 129 seconds, but is the first
		// thing an attacker will try.
		if ($this->CommonPasswordFile) {
			if (!file_exists($this->CommonPasswordFile)) {
				throw new Exception('Common passwords file was not found');
			}
			if (!is_readable($this->CommonPasswordFile)) {
				throw new Exception('Common passwords file was not readable (check permissions)');
			}
			$file = fopen($this->CommonPasswordFile,'rb');
			$text = strtolower($password);
			while (!feof($file)) {
				$common = fgets($file);
				$common = trim($common);
				if ($common==$text) {
					// If their password exists in the common file, then it's 
					// zero time to crack this terrible password.
					fclose($file);
					return -1;
				}
			}
			fclose($file);
			unset($file);
			unset($text);
			unset($common);
		}

		// Figure out which character set the password is using (based on the most 
		// "complex" character in it).
		$base = '';
		$baseKey = null;
		for ($t=0; $t<strlen($password); $t++) {
			$char = $password[$t];
			$foundChar = false;
			foreach ($this->CharacterSets as $characterSetKey=>$characterSet) {
				if ($baseKey<=$characterSetKey && strpos($characterSet,$char)!==false) {
					$baseKey = $characterSetKey;
					$base = $characterSet;
					$foundChar = true;
					break;
				}
			}
			// If the character we were looking for wasn't anywhere in any of the 
			// character sets, assign the largest (last) character set as default.
			if (!$foundChar) {
				$base = end($this->CharacterSets);
				break;
			}
		}
		unset($baseKey);
		unset($foundChar);

		// Starting at the first character, figure out it's position in the character set
		// and how many attempts will take to get there. For example, say your password
		// was an integer (a bank card PIN number for example):
		// 0 (or 0000 if you prefer) would be the very first password they attempted by the attacker.
		// 9999 would be the last password they attempted (assuming 4 characters).
		// Thus a password/PIN of 6529 would take 6529 attempts until the attacker found
		// the proper combination. The same logic words for alphanumeric passwords, just
		// with a larger number of possibilities for each position in the password. The 
		// key thing to note is the attacker doesn't need to test the entire range (every
		// possible combination of all characters) they just need to get to the point in
		// the list of possibilities that is your password. They can (in this example) 
		// ignore anything between 6530 and 9999. Using this logic, 'aaa' would be a worse
		// password than 'zzz', because the attacker would encounter 'aaa' first. 
		$attempts = 0;
		$charactersInBase = strlen($base);
		$charactersInPassword = strlen($password);
		for ($position=0; $position<$charactersInPassword; $position++) {
			// We power up to the reverse position in the string. For example, if we're trying 
			// to hack the 4 character PING code in the example above:
			// First number * (number of characters possible in the charset ^ length of password)
			// ie: 6 * (10^4) = 6000
			// then add that same equation for the second number:
			// 5 * (10^3) = 500
			// then the third numbers
			// 2 * (10^2) = 20
			// and add on the last number
			// 9
			// Totals: 6000 + 500 + 20 + 9 = 6529 attempts before we encounter the correct password.
			$powerOf = $charactersInPassword - $position - 1;
			// Character position within the base set. We add one on because strpos is base 
			// 0, we want base 1.
			$charAtPosition = strpos($base,$password[$position])+1;
			// If we're at the last character, simply add it's position in the character set
			// this would be the "9" in the pin code example above.
			if ($powerOf==0) {
				$attempts = bcadd($attempts,$charAtPosition);
			}
			// Otherwise we need to iterate through all the other characters positions to 
			// get here. For example, to find the 5 in 25 we can't just guess 2 and then 5
			// (even though Hollywood seems to insist this is possible), we need to try 0,1,
			// 2,3...15,16,17...23,24,25 (got it).
			else {
				// This means we have to try every combination of values up to this point for 
				// all previous characters. Which means we need to iterate through the entire 
				// character set, X times, where X is our position -1. Then we need to multiply 
				// that by this character's position.

				// Multiplier is the (10^4) or (10^3), etc in the pin code example above.
				$multiplier = bcpow($charactersInBase,$powerOf);
				// New attempts is the number of attempts we're adding for this position.
				$newAttempts = bcmul($charAtPosition,$multiplier);
				// Add that on to our existing number of attempts.
				$attempts = bcadd($attempts,$newAttempts);
			}
		}

		// We can (worst case) try a billion passwords a second. Calculate how many days it
		// will take us to get to the password.
		$perDay = bcmul($this->HashesPerSecond,60*60*24);

		// This allows us to calculate a number of days to crack. We use days because anything
		// that can be cracked in less than a day is basically useless, so there's no point in
		// having a smaller granularity (hours for example).
		$days = bcdiv($attempts,$perDay);

		// If it's going to take more than a billion days to crack, just return a billion. This
		// helps when code outside this function isn't using bcmath. Besides, if the password 
		// can survive 2.7 million years it's probably ok.
		if (bccomp($days,1000000000)==1) {
			return 1000000000;
		}

		return round($days);

	}

}

