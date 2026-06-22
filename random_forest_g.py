import os
import pandas as pd
import numpy as np
import sys
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
from sklearn.preprocessing import LabelEncoder
from sklearn.tree import export_graphviz
import graphviz
import pydotplus
from PIL import Image

# Explicitly add Graphviz bin directory to the PATH
os.environ["PATH"] += os.pathsep + r"C:\Program Files\Graphviz\bin"

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
       # model = RandomForestClassifier(n_estimators=10, random_state=42)  # 10 trees for simplicity
        model = RandomForestClassifier(n_estimators=10, random_state=42, max_depth=5)  # Limit tree depth to 5

        model.fit(X_train, y_train)

        # Predictions
        y_pred = model.predict(X_test)
        accuracy = accuracy_score(y_test, y_pred)

        print(f"Random Forest Accuracy: {accuracy * 100:.2f}%")

        # Visualize a single tree from the Random Forest
        tree_index = 0  # Select the first tree in the forest
        feature_names = X.columns.tolist()  # Get feature names

        dot_data = export_graphviz(
            model.estimators_[tree_index],  
            out_file=None,
            feature_names=feature_names,
            class_names=[str(c) for c in np.unique(y)],
            filled=True,
            rounded=True,
            special_characters=True
        )

        # Convert to a graph and save as an image
        graph = pydotplus.graph_from_dot_data(dot_data)
        graph.write_png("tree.png")

        # Display the image
        img = Image.open("tree.png")
        img.show()

    except Exception as e:
        print(f"Error: {str(e)}")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python random_forest.py <path_to_csv>")
    else:
        run_random_forest(sys.argv[1])
