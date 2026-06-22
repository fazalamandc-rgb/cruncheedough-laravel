import sys
import joblib
import pandas as pd
from sklearn.linear_model import LinearRegression

# Get the CSV file path from the command line argument
csv_file = sys.argv[1]

# Load the dataset
data = pd.read_csv(csv_file)

# Assume the last column is the target and the rest are features
X = data[['x']]  # Feature (x values)
y = data['y']    # Target (y values)

# Create and train the Linear Regression model
model = LinearRegression()
model.fit(X, y)

# Save the trained model using joblib
model_save_path = 'C:/inetpub/wwwroot/larval-Crunchee/linear_regression_model.pkl'
joblib.dump(model, model_save_path)

#joblib.dump(model, 'linear_regression_model.pkl')
#print("Model saved successfully")


#import os
#print("Current working directory:", os.getcwd())

# If you want to make predictions, take the first row's feature and predict the target
sample_input = X.iloc[0].values.reshape(1, -1)
prediction = model.predict(sample_input)

# Output the prediction result (this could be returned as needed)
print(f"Prediction for x={sample_input[0][0]}: {prediction[0]}")
