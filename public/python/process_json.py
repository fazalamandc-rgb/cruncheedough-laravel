import sys
import json

# Get JSON string from the command-line argument
data = json.loads(sys.argv[1])  # sys.argv[1] contains the JSON

num1 = data['num1']
num2 = data['num2']
action = data['action']

if action == 'add':
    result = num1 + num2
elif action == 'subtract':
    result = num1 - num2
else:
    result = 'Invalid action'

# Output the result
print(f"Result: {result}")
