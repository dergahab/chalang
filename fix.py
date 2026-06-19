import codecs
import re

with open('work_log.md', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

# Try to automatically fix utf-8 mojibake (ftfy style)
def fix_mojibake(text):
    try:
        # If it was utf-8 decoded as windows-1252/iso-8859-1 and saved as utf-8
        return text.encode('windows-1252').decode('utf-8')
    except:
        return text

# Manual fallback replacements if auto doesn't work perfectly
replacements = {
    'Ä°': 'İ', 'Ã§': 'ç', 'Ä±': 'ı', 'dÃ¼zÉ™ldildi': 'düzəldildi',
    'xÉ™tasÄ±': 'xətası', 'dÉ™yiÅŸdirildi': 'dəyişdirildi', 'É™lavÉ™': 'əlavə',
    'Ã§aÄŸÄ±rÄ±ÅŸlarÄ±': 'çağırışları', 'sÃ¼tunlu': 'sütunlu', 'aÃ§Ä±qlama': 'açıqlama',
    'SaÄŸ sÃ¼tun': 'Sağ sütun', 'partikÃ¼l': 'partikül', 'bÉ™rabÉ™r': 'bərabər',
    'Ã¼fÃ¼qi': 'üfüqi', 'mÉ™qalÉ™': 'məqalə', 'dÃ¼zÃ¼lÃ¼ÅŸÃ¼': 'düzülüşü',
    'Ã¶z davranÄ±ÅŸÄ±dÄ±r': 'öz davranışıdır', 'tÉ™rÉ™findÉ™n': 'tərəfindən',
    'aÃ§Ä±ldÄ±': 'açıldı', 'heÃ§': 'heç', 'aÅŸkar': 'aşkar', 'edilmÉ™di': 'edilmədi',
    'ğŸ“ ': '📝', 'âœ…': '✅', 'â€”': '—', 'É™': 'ə', 'Ã§': 'ç', 'Ä±': 'ı',
    'ÅŸ': 'ş', 'Ã¶': 'ö', 'Ã¼': 'ü', 'ÄŸ': 'ğ', 'Ã–': 'Ö', 'Ãœ': 'Ü',
    'Åž': 'Ş', 'Äž': 'Ğ', 'Ã‡': 'Ç', 'â€²': '´'
}

for k, v in replacements.items():
    text = text.replace(k, v)

with open('work_log.md', 'w', encoding='utf-8') as f:
    f.write(text)
