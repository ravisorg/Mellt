require 'test/unit'
require './Mellt.rb'

class MelltTest < Test::Unit::TestCase
	# character sets
	@@numeric = '0123456789'
	@@alpha = 'abcdefghijklmnopqrstuvwxyz'
	@@alpha_numeric = 'abcdefghijklmnopqrstuvwxyz0123456789'
	@@complex = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@\#$%^&*()-=_+"
	@@extra_complex = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@\#$%^&*()-=_+[]\"{}|;':,./<>?`~"

    def test_char_set_single_number
        m = Mellt.new()
        password = '1'
        self.assert_equal(@@numeric, m.get_char_set(password))
    end

    def test_char_set_single_letter
        m = Mellt.new()
        password = 'a'
        self.assert_equal(@@alpha, m.get_char_set(password))
    end

    def test_char_set_single_funny_character
        m = Mellt.new()
        password = '$'
        self.assert_equal(@@complex, m.get_char_set(password))
    end

    def test_char_set_single_extra_funny_character
        m = Mellt.new()
        password = '['
        self.assert_equal(@@extra_complex, m.get_char_set(password))
    end

    def test_char_set_multiple_numbers
        m = Mellt.new()
        password = '1234567890'
        self.assert_equal(@@numeric, m.get_char_set(password))
    end

    def test_char_set_alphanum_numbers
        m = Mellt.new()
        password = 'abc123'
        self.assert_equal(@@alpha_numeric, m.get_char_set(password))
    end

    def test_char_set_multiple_funny_characters
        m = Mellt.new()
        password = 'asdva98dfv79au******&^*&^&^$##%$#@*&'
        self.assert_equal(@@complex, m.get_char_set(password))
    end

    def test_char_set_multiple_extra_funny_characters
        m = Mellt.new()
        password = 'abc123[][][\][ap[sdfp][pasd]f[a9sdf7989*&^*&^%&'
        self.assert_equal(@@extra_complex, m.get_char_set(password))
    end

    def test_first_common
        m = Mellt.new()
        password = 'password'
        self.assert_equal(true, m.check_common(password))
    end

    def test_last_common
        m = Mellt.new()
        password = 'eyphed'
        self.assert_equal(true, m.check_common(password))
    end

    def test_not_common
        m = Mellt.new()
        password = 'pass123$'
        self.assert_equal(false, m.check_common(password))
    end

    def test_short_brute_force
        m = Mellt.new()
        password = "pass123$"
        #value taken from the php version
        self.assert_equal(2, m.brute_force_days(password))
    end

    def test_short_brute_force_numeric
        m = Mellt.new()
        password = "6529"
        #value taken from the php version
        self.assert_equal(0, m.brute_force_days(password))
    end

    def test_max_brute_force_common
        m = Mellt.new()
        password = 'this-password-is-really-really-long'
        #value taken from the php version
        self.assert_equal(1000000000, m.brute_force_days(password))
    end

    def test_check_empty_password
        m = Mellt.new()
        password = ''
        self.assert_equal(-1, m.check_password(password))
    end

    def test_check_common_password
        m = Mellt.new()
        password = 'password'
        self.assert_equal(-1, m.check_password(password))
    end

    def test_two_day_password
        m = Mellt.new()
        password = 'pass123$'
        self.assert_equal(2, m.check_password(password))
    end

    def test_long_crack_password
        m = Mellt.new()
        password = 'correcthorsebatterystaple'  # https://xkcd.com/936/
        self.assert_equal(1000000000, m.check_password(password))
    end
end
