# app.py
from flask import Flask, request, jsonify
import joblib

# Initialize Flask app
app = Flask(__name__)

# Load the trained model (make sure the file 'bike_demand_model.pkl' exists)
model = joblib.load('bike_demand_model.pkl')

@app.route('/predict', methods=['POST'])
def predict():
    # Get JSON data from the request
    data = request.json
    # Extract features from the request (ensure these match your model’s training data)
    features = [data['hour'], data['day_of_week'], data['temperature']]
    
    # Make prediction using the loaded model
    prediction = model.predict([features])
    
    # Return the prediction as a JSON response
    return jsonify({'bike_demand': int(prediction[0])})

# Run the Flask app
if __name__ == '__main__':
    app.run(debug=True)

