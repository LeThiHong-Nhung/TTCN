const patternEmail = r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$';
const patternName = r'^[a-z A-Z]+$';
const patternAddress = r'^[a-z A-Z 0-9 / ,]+$';
const patternPhone = r'(^(?:[+0]9)?[0-9]{10,12}$)';
const patternCMND = r'(^(?:[+0]9)?[0-9]{9,12}$)';
const patternPass = r'^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#\$&*~]).{8,}$';

bool isValid(String string, String pattern) {
  // Null or empty string is invalid
  if (string == null || string.isEmpty) {
    return false;
  }
  final regExp = RegExp(pattern);
  if (!regExp.hasMatch(string)) {
    return false;
  }
  return true;
}

var USERNAME = null;
var EMAIL = null;
