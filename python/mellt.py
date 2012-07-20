class Mellt:

	def __init__(self):
		self.char_sets = {
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
		base = False
		base_key = 99
		for char in password:
			found_character = False
			
			for key,character_set in self.char_sets.iteritems() :
				if key <= base_key and character_set.find(char) != -1 :
					found_character = True
					base = character_set
					base_key = key
					break
			# If the character we were looking for wasn't anywhere in any of the 
			# character sets, assign the largest (last) character set as default.
			if found_character == False:
				base = self.char_sets[len(self.char_sets) - 1]
				break
		self.password_char_set = base
		return base
