import sys
import os
import re
import json
import fitz  # PyMuPDF
from PIL import Image
import pytesseract

def extract_text_from_file(file_path):
    if file_path.lower().endswith(".pdf"):
        text = ""
        try:
            doc = fitz.open(file_path)
            for page in doc:
                text += page.get_text()
        except Exception as e:
            print(json.dumps({"error": f"Failed to read PDF: {str(e)}"}))
            sys.exit(1)
        return text
    else:
        try:
            image = Image.open(file_path)
            return pytesseract.image_to_string(image)
        except Exception as e:
            print(json.dumps({"error": f"Failed to read image: {str(e)}"}))
            sys.exit(1)

def extract_cgpa(text):
    match = re.search(r'(CGPA|GPA)[^\d]*(\d\.\d+)', text, re.IGNORECASE)
    return float(match.group(2)) if match else 0.0

def extract_subjects(text):
    subjects = []
    common_subjects = ["Mathematics", "Physics", "Computer", "AI", "Data Science", "Electronics"]
    for sub in common_subjects:
        if re.search(sub, text, re.IGNORECASE):
            subjects.append(sub)
    return subjects

def load_universities():
    try:
        with open("db/universities.json", "r", encoding="utf-8") as f:
            data = json.load(f)
            # Ensure it's a list of dictionaries
            if not isinstance(data, list) or not all(isinstance(u, dict) for u in data):
                raise ValueError("Invalid format in universities.json")
            return data
    except Exception as e:
        print(json.dumps({"error": f"Failed to load universities: {str(e)}"}))
        sys.exit(1)

def recommend_universities(cgpa, subjects, universities):
    recommended = []
    for uni in universities:
        if "min_cgpa" in uni and "majors" in uni:
            if isinstance(uni["min_cgpa"], (int, float)) and isinstance(uni["majors"], list):
                if cgpa >= uni["min_cgpa"]:
                    if any(sub in uni["majors"] for sub in subjects):
                        recommended.append({
                            "name": uni["name"],
                            "country": uni["country"]
                        })
    return recommended

def main():
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No file provided"}))
        return

    file_path = sys.argv[1]
    if not os.path.exists(file_path):
        print(json.dumps({"error": "File not found"}))
        return

    text = extract_text_from_file(file_path)
    cgpa = extract_cgpa(text)
    subjects = extract_subjects(text)
    universities = load_universities()
    recommended = recommend_universities(cgpa, subjects, universities)

    print(json.dumps(recommended, indent=2))

if __name__ == "__main__":
    main()
