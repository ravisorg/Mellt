require 'test/unit'
require './Mellt.rb'

#make the methods public for testing
class MelltPublic < Mellt
  def get_char_set(password)
  super(password)
  end
  def check_common(password)
  super(password)
  end
  def brute_force_days(password)
  super(password)
  end
end

class MelltTest < Test::Unit::TestCase
  # character sets
  @@numeric = '0123456789'
  @@alpha = 'abcdefghijklmnopqrstuvwxyz'
  @@alpha_numeric = 'abcdefghijklmnopqrstuvwxyz0123456789'
  @@complex = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@\#$%^&*()-=_+"
  @@extra_complex = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@\#$%^&*()-=_+[]\"{}|;':,./<>?`~"

  def test_char_set_single_number
    m = MelltPublic.new()
    password = '1'
    self.assert_equal(@@numeric, m.get_char_set(password))
  end

  def test_char_set_single_letter
    m = MelltPublic.new()
    password = 'a'
    self.assert_equal(@@alpha, m.get_char_set(password))
  end

  def test_char_set_single_funny_character
    m = MelltPublic.new()
    password = '$'
    self.assert_equal(@@complex, m.get_char_set(password))
  end

  def test_char_set_single_extra_funny_character
    m = MelltPublic.new()
    password = '['
    self.assert_equal(@@extra_complex, m.get_char_set(password))
  end

  def test_char_set_multiple_numbers
    m = MelltPublic.new()
    password = '1234567890'
    self.assert_equal(@@numeric, m.get_char_set(password))
  end

  def test_char_set_alphanum_numbers
    m = MelltPublic.new()
    password = 'abc123'
    self.assert_equal(@@alpha_numeric, m.get_char_set(password))
  end

  def test_char_set_multiple_funny_characters
    m = MelltPublic.new()
    password = 'asdva98dfv79au******&^*&^&^$##%$#@*&'
    self.assert_equal(@@complex, m.get_char_set(password))
  end

  def test_char_set_multiple_extra_funny_characters
    m = MelltPublic.new()
    password = 'abc123[][][\][ap[sdfp][pasd]f[a9sdf7989*&^*&^%&'
    self.assert_equal(@@extra_complex, m.get_char_set(password))
  end

  def test_first_common
    m = MelltPublic.new()
    password = 'password'
    self.assert_equal(true, m.check_common(password))
  end

  def test_last_common
    m = MelltPublic.new()
    password = 'eyphed'
    self.assert_equal(true, m.check_common(password))
  end

  def test_not_common
    m = MelltPublic.new()
    password = 'pass123$'
    self.assert_equal(false, m.check_common(password))
  end

  def test_short_brute_force
    m = MelltPublic.new()
    password = "pass123$"
    #value taken from the php version
    self.assert_equal(2, m.brute_force_days(password))
  end

  def test_short_brute_force_numeric
    m = MelltPublic.new()
    password = "6529"
    #value taken from the php version
    self.assert_equal(0, m.brute_force_days(password))
  end

  def test_max_brute_force_common
    m = MelltPublic.new()
    password = 'this-password-is-really-really-long'
    #value taken from the php version
    self.assert_equal(1000000000, m.brute_force_days(password))
  end

  def test_check_empty_password
    m = MelltPublic.new()
    password = ''
    self.assert_equal(-1, m.check_password(password))
  end

  def test_check_common_password
    m = MelltPublic.new()
    password = 'password'
    self.assert_equal(-1, m.check_password(password))
  end

  def test_two_day_password
    m = MelltPublic.new()
    password = 'pass123$'
    self.assert_equal(2, m.check_password(password))
  end

  def test_long_crack_password
    m = MelltPublic.new()
    password = 'correcthorsebatterystaple'  # https://xkcd.com/936/
    self.assert_equal(1000000000, m.check_password(password))
  end
end
