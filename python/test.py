import unittest
import mellt

class TestMellt(unittest.TestCase):

	def test_char_set_single_number(self):
		m = mellt.Mellt()
		password = '1';
		m.get_char_set(password)
		self.assertEqual('0123456789', m.password_char_set)

	def test_char_set_single_letter(self):
		m = mellt.Mellt()
		password = 'a';
		m.get_char_set(password)
		self.assertEqual('abcdefghijklmnopqrstuvwxyz', m.password_char_set)

	def test_char_set_single_funny_character(self):
		m = mellt.Mellt()
		password = '$';
		m.get_char_set(password)
		self.assertEqual("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+", m.password_char_set)

	def test_char_set_single_extra_funny_character(self):
		m = mellt.Mellt()
		password = '[';
		m.get_char_set(password)
		self.assertEqual("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+[]\"{}|;':,./<>?`~", m.password_char_set)

	def test_char_set_multiple_numbers(self):
		m = mellt.Mellt()
		password = '1234567890';
		m.get_char_set(password)
		self.assertEqual('0123456789', m.password_char_set)

if __name__ == '__main__':
    unittest.main()