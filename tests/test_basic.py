"""
Basic tests for sindhumatri repository
"""
import unittest
import os


class TestBasic(unittest.TestCase):
    """Basic test cases"""
    
    def test_readme_exists(self):
        """Test that README.md exists"""
        self.assertTrue(os.path.exists('README.md'), "README.md should exist")
    
    def test_readme_not_empty(self):
        """Test that README.md is not empty"""
        if os.path.exists('README.md'):
            with open('README.md', 'r') as f:
                content = f.read()
                self.assertGreater(len(content), 0, "README.md should not be empty")


if __name__ == '__main__':
    unittest.main()

