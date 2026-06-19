import re
import os
from datetime import datetime

file_path = r'c:\xampp\htdocs\chalang\work_log.md'

def extract_date(content):
    # Try to find date in header like [ID-026] - 2026-05-08
    header_date = re.search(r'### \[ID-\d+\]\s*-\s*(\d{4}-\d{2}-\d{2})', content)
    if header_date:
        return header_date.group(1)
    
    # Try to find date in content like **Tarix:** 2026-05-05 07:26:34
    tarix_match = re.search(r'\*\*Tarix:\*\*\s*(\d{4}-\d{2}-\d{2})', content)
    if tarix_match:
        return tarix_match.group(1)
    
    return "1970-01-01" # Fallback

def process_log():
    if not os.path.exists(file_path):
        print("File not found")
        return

    with open(file_path, 'r', encoding='utf-8', errors='replace') as f:
        full_content = f.read()

    # Split into header and entries
    parts = re.split(r'(### \[ID-)', full_content)
    
    header = parts[0]
    entries_raw = []
    
    # Parts will look like [header, '### [ID-', '001] content...', '### [ID-', '002] content...']
    for i in range(1, len(parts), 2):
        if i + 1 < len(parts):
            entries_raw.append(parts[i] + parts[i+1])

    # Parse entries into objects with date
    parsed_entries = []
    for entry in entries_raw:
        date_str = extract_date(entry)
        parsed_entries.append({
            'date': date_str,
            'content': entry
        })

    # Sort by date
    parsed_entries.sort(key=lambda x: x['date'])

    # Re-number and clean up IDs
    final_content = header.strip() + "\n\n"
    
    for idx, entry in enumerate(parsed_entries, 1):
        new_id = f"ID-{idx:03d}"
        content = entry['content']
        
        # Replace old ID in header
        content = re.sub(r'### \[ID-\d+\]', f'### [{new_id}]', content)
        
        final_content += content.strip() + "\n\n"

    # Write back
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(final_content)
    
    print(f"Successfully processed {len(parsed_entries)} entries.")

if __name__ == "__main__":
    process_log()
