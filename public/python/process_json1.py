import sys
import json

def main():
    data = json.loads(sys.argv[1])
    num1 = data.get('num1')
    num2 = data.get('num2')
    action = data.get('action')

    result = None

    if action == 'add':
        result = num1 + num2
    elif action == 'subtract':
        result = num1 - num2
    elif action == 'multiply':
        result = num1 * num2
    elif action == 'divide':
        if num2 == 0:
            result = 'Error: Division by zero'
        else:
            result = num1 / num2
    else:
        result = 'Unsupported action'

    print(result)

if __name__ == '__main__':
    main()
