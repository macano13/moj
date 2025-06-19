from flask import Flask, jsonify, request, render_template, redirect, session
from datetime import datetime, timedelta
import os
import requests

app = Flask(__name__)
app.secret_key = "your_secret_key"  # Replace with your actual secret key

# OpenSubtitles API Configuration
OPENSUBTITLES_API_URL = "https://api.opensubtitles.com/api/v1/subtitles"
API_KEY = "2283anwAgKFVrfqaRui4QRmFHpKcQd1Z"  # Replace with your actual OpenSubtitles API key
USER_AGENT = "Temporary/UserAgent"

# Temporary directory for subtitle files
TEMP_DIR = "/mnt/volume-fsn1-1/web/search/temp"
if not os.path.exists(TEMP_DIR):
    os.makedirs(TEMP_DIR, exist_ok=True)

# Simulated user retrieval function (replace with actual user logic)
def get_user():
    # Example user object (fetch this data from a database or session)
    return {
        'expire_date': '2024-12-31',  # Example expiry date
        'is_active': 1                # Example active status (1 = active, 0/2 = inactive)
    }

# Root route with access control
@app.route('/search/')
def index():
    user = get_user()  # Retrieve user information
    
    if not user:
        return redirect('/payment')  # Redirect if no user is found

    # Check subscription expiry
    expire_date = user.get('expire_date')
    is_active = user.get('is_active')

    if not expire_date:
        return redirect('/payment')

    # Extend expiration date by 10 days as grace period
    extend_expired_date = (datetime.strptime(expire_date, '%Y-%m-%d') + timedelta(days=10)).date()
    today_date = datetime.today().date()

    if today_date > extend_expired_date:
        return redirect('/payment')

    # Check if the user is active
    if is_active in [0, 2]:
        return redirect('/payment')

    # Render the search frontend if access is valid
    return render_template('index.html')

# Payment page route (placeholder for your actual payment page)
@app.route('/payment')
def payment():
    return "Payment Page - Please renew your subscription."

# Fetch subtitles
@app.route('/api/subtitles', methods=['GET'])
def get_subtitles():
    query = request.args.get('query')
    lang = request.args.get('lang')
    
    headers = {
        'Api-Key': API_KEY,
        'User-Agent': USER_AGENT
    }
    
    params = {
        'query': query,
        'languages': lang
    }

    try:
        response = requests.get(OPENSUBTITLES_API_URL, headers=headers, params=params)
        response.raise_for_status()
        subtitles_data = response.json()
        subtitles = []
        
        for sub in subtitles_data['data']:
            subtitles.append({
                'id': sub['attributes']['files'][0]['file_id'],
                'name': sub['attributes']['files'][0]['file_name']
            })

        return jsonify({'subtitles': subtitles})

    except Exception as e:
        print(f"Error occurred: {e}")
        return jsonify({'error': 'Unable to fetch subtitles'}), 500

# Download a subtitle by ID
@app.route('/api/subtitles/download/<subtitle_id>', methods=['GET'])
def download_subtitle(subtitle_id):
    try:
        subtitle_url = "https://api.opensubtitles.com/api/v1/download/"
        headers = {
            'Api-Key': API_KEY,
            'User-Agent': USER_AGENT
        }

        params = {
            'file_id': subtitle_id
        }
        
        response = requests.post(subtitle_url, headers=headers, params=params)
        response_data = response.json()
        download_link = response_data.get("link")

        if download_link:
            subtitle_response = requests.get(download_link)
            subtitle_response.raise_for_status()
            
            subtitle_path = os.path.join(TEMP_DIR, 'subtitle.srt')
            with open(subtitle_path, 'wb') as f:
                f.write(subtitle_response.content)

            @after_this_request
            def cleanup(response):
                try:
                    os.remove(subtitle_path)
                except Exception as e:
                    print(f"Error cleaning up subtitle file: {e}")
                return response

            return send_file(subtitle_path, as_attachment=True)
        else:
            return jsonify({'error': 'Download link not found'}), 500

    except Exception as e:
        print(f"Error occurred during subtitle download: {e}")
        return jsonify({'error': 'Unable to download subtitle'}), 500

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
