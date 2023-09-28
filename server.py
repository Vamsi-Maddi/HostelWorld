import random
import json
import nltk
import http.server
import socketserver
import urllib.parse

# Download required NLTK resources
nltk.download('punkt')

class Chatbot:
    def __init__(self, intents_file):
        self.intents = self.load_intents(intents_file)

    def load_intents(self, filename):
        with open(filename, "r") as f:
            intents = json.load(f)["intents"]
        return intents

    def preprocess_text(self, text):
        words = nltk.word_tokenize(text)
        return [word.lower() for word in words]

    def get_intent(self, user_input):
        user_tokens = self.preprocess_text(user_input)
        for intent in self.intents:
            patterns = intent.get("patterns", [])
            for pattern in patterns:
                pattern_tokens = self.preprocess_text(pattern)
                if all(token in user_tokens for token in pattern_tokens):
                    return intent
        return None

    def generate_response(self, intent):
        if intent is not None:
            response = random.choice(intent["responses"])
            return response
        return "I'm sorry, I don't understand that."

class ChatbotRequestHandler(http.server.SimpleHTTPRequestHandler):
    def __init__(self, *args, **kwargs):
        self.chatbot = Chatbot("hostel.json")
        super().__init__(*args, **kwargs)

    def do_POST(self):
        content_length = int(self.headers['Content-Length'])
        post_data = self.rfile.read(content_length)
        parsed_data = urllib.parse.parse_qs(post_data.decode('utf-8'))
        
        if 'user_input' in parsed_data:
            user_input = parsed_data['user_input'][0]
            intent = self.chatbot.get_intent(user_input)
            response = self.chatbot.generate_response(intent)
            self.send_response(200)
            self.send_header('Content-type', 'application/json')
            self.end_headers()
            self.wfile.write(json.dumps({'response': response}).encode('utf-8'))
        else:
            self.send_response(400, 'Bad Request')
            self.end_headers()

def run_server():
    PORT = 8000
    with socketserver.TCPServer(("", PORT), ChatbotRequestHandler) as httpd:
        print("Server started at port", PORT)
        httpd.serve_forever()

if __name__ == '__main__':
    run_server()
