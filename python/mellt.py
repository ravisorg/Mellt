class Mellt:

	def __init__(self):
		self.char_sets = ["0123456789", "abcdefghijklmnopqrstuvwxyz", "abcdefghijklmnopqrstuvwxyz0123456789", "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+", "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+[]\"{}|;':,./<>?`~"]

	def get_char_set (self, password):
		password = list(password)
		self.password_char_set = ''
		base = False
		found_count = 0
		for char in password:
			found_character = False
			
			for character_set in self.char_sets :
				if base != character_set and character_set.find(char) != -1 :
					found_character = True
					base = character_set
					found_count += 1
					if found_count == len(password):
						self.password_char_set = base
						return base
					break
			# If the character we were looking for wasn't anywhere in any of the 
			# character sets, assign the largest (last) character set as default.
			if found_character == False:
				base = self.char_sets[len(self.char_sets) - 1]
				break
		self.password_char_set = base
		return base
