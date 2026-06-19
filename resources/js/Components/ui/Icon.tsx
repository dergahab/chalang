/**
 * Icon Component - Wrapper for Lucide React icons
 */
import { LucideIcon, icons as lucideIcons } from 'lucide-react';

export type IconName = keyof typeof lucideIcons;

interface IconProps {
    name: IconName;
    size?: number;
    strokeWidth?: number;
    className?: string;
}

export function Icon({ name, size = 20, strokeWidth = 2, className = '' }: IconProps) {
    const IconComponent = lucideIcons[name] as LucideIcon;
    
    if (!IconComponent) {
        console.warn(`Icon "${name}" not found`);
        return null;
    }
    
    return <IconComponent size={size} strokeWidth={strokeWidth} className={className} />;
}

export {
    Menu, X, ChevronDown, ArrowRight, ExternalLink,
    Check, Search, Mail, Phone, Globe, MapPin, Share,
    Moon, Sun, Settings, User, Users, Plus, Minus,
    AlertCircle, Info, HelpCircle, CheckCircle,
    Loader, RefreshCw, Eye, EyeOff,
} from 'lucide-react';

export default Icon;