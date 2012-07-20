class Mellt:

	def __init__(self):
		self.character_sets = {
			1:"0123456789",
			2:"abcdefghijklmnopqrstuvwxyz",
			3:"abcdefghijklmnopqrstuvwxyz0123456789",
			4:"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
			5:"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
			6:"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+",
			7:"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+[]\"{}|;':,./<>?`~"
		}

	def get_char_set (self, password):
		password = list(password)
		self.password_char_set = ''
		# Figure out which character set the password is using (based on the most 
		# "complex" character in it).
		base = '';
		base_key = None;
		for char in password:
			found_char = False;
			for character_set_key, character_set in self.character_sets.iteritems():
				if base_key<=character_set_key and char in character_set:
					base_key = character_set_key;
					base = character_set;
					found_char = True;
					break;
			
			# If the character we were looking for wasn't anywhere in any of the 
			# character sets, assign the largest (last) character set as default.
			if found_char == False:
				base = self.character_sets[7];
				break;
		self.password_char_set = base
		return base

	def check_common(self, password):
		password = password.lower()
		for line in open('common-passwords.txt','r'):
			line = line.rstrip()
			if password == line:
				return True
		return False