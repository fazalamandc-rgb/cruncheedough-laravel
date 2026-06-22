import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
from sklearn.preprocessing import LabelEncoder
import sys

def run_random_forest(file_path):
    try:
        # Load dataset
        data = pd.read_csv(file_path)

        # Assume the last column is the target, and the rest are features
        X = data.iloc[:, :-1]
        y = data.iloc[:, -1]

        # Convert categorical columns to numeric using LabelEncoder
        label_encoder = LabelEncoder()
        for column in X.select_dtypes(include=['object']).columns:  # Find columns with categorical data
            X[column] = label_encoder.fit_transform(X[column])

        # Split the data
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=42)

        # Train Random Forest
        model = RandomForestClassifier(random_state=42)
        model.fit(X_train, y_train)

        # Predictions
        y_pred = model.predict(X_test)
        accuracy = accuracy_score(y_test, y_pred)

        print(f"Random Forest Accuracy: {accuracy * 100:.2f}%")
    except Exception as e:
        print(f"Error: {str(e)}")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python random_forest.py <path_to_csv>")
    else:
        run_random_forest(sys.argv[1])
