# Phase 2: Click-Based Language Switcher

## Goal
Convert the Language Switcher in the Navbar from a hover-based interaction (CSS `group-hover`) to a click-based interaction (React State) to improve usability on touch devices and conform to the new UX standard.

## User Review Required
> [!NOTE]
> This change mainly affects the desktop/laptop experience. Mobile menu often has its own language selector, but this specific component is the "desktop" one (visible on lg/xl screens).

## Proposed Changes

### [search-overlay](c:\xampp\htdocs\chalang\resources\js\Components\Navbar.tsx)

#### [MODIFY] Navbar.tsx
1.  **State Management**:
    -   Add `const [langOpen, setLangOpen] = useState(false);`
    -   Implement `toggleLang` function.
2.  **Mutual Exclusivity**:
    -   `toggleLang`: Close `activeMenu` (main nav) and `searchOpen` when opening language.
    -   `handleMouseEnter` (Main Nav): `setLangOpen(false)` (Hovering nav closes language).
    -   `toggleSearch`: `setLangOpen(false)` (Opening search closes language).
3.  **Event Handling**:
    -   Add `onClick={toggleLang}` to the Language button.
    -   Implement `useEffect` for "Click Outside" detection to close the dropdown when clicking elsewhere.
4.  **Styling**:
    -   Remove `group-hover` classes.
    -   Use conditional template literals for `opacity`, `visibility`, and `transform` based on `langOpen`.

## Verification Plan

### Automated Tests
-   None (UI interaction).

### Manual Verification
1.  **Click Interaction**:
    -   Click "EN" (or current lang). Dropdown must appear.
    -   Click again. Dropdown must close.
2.  **Click Outside**:
    -   Open Dropdown. Click anywhere else on the page body. Dropdown must close.
3.  **Mutual Exclusivity**:
    -   Open Dropdown. Hover over "Services" (Main Menu). Dropdown must close.
    -   nav-item hover. Click "EN". Nav-item should lose active state (or at least dropdown shouldn't overlap weirdly).
4.  **Search Interaction**:
    -   Open Dropdown. Click Search icon. Dropdown must close, Search Overlay must open.
