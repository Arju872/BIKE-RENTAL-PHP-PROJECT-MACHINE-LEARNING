# /python_ml/train_model.py

import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression
import joblib

# Load the dataset (replace with actual path or data)
data = pd.read_csv('bike_rental_data.csv')
df = pd.read_csv('bike_rental_data.csv')
print(df.columns)

# Prepare the features (X) and the target (y)
X = data[['hour', 'day_of_week', 'temperature']]  # Features
y = data['bike_count']  # Target (bike demand)

# Split data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Create and train the model
model = LinearRegression()
model.fit(X_train, y_train)

# Save the model to a file
joblib.dump(model, 'bike_model.pkl')

print("Model trained and saved as bike_model.pkl")