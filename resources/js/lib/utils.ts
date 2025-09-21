import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const getStatusColorClasses = (color: string): string[] => {
  switch (color) {
    case 'green':
      return ['bg-green-100', 'text-green-800', 'dark:bg-green-900', 'dark:text-green-300'];
    case 'red':
      return ['bg-red-100', 'text-red-800', 'dark:bg-red-900', 'dark:text-red-300'];
    case 'blue':
      return ['bg-blue-100', 'text-blue-800', 'dark:bg-blue-900', 'dark:text-blue-300'];
    case 'yellow':
      return ['bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-900', 'dark:text-yellow-300'];
    case 'orange':
      return ['bg-orange-100', 'text-orange-800', 'dark:bg-orange-900', 'dark:text-orange-300'];  
    case 'purple':
      return ['bg-purple-100', 'text-purple-800', 'dark:bg-purple-900', 'dark:text-purple-300'];
    case 'cyan':
      return ['bg-cyan-100', 'text-cyan-800', 'dark:bg-cyan-900', 'dark:text-cyan-300'];
    case 'gray':
    default:
      return ['bg-gray-100', 'text-gray-800', 'dark:bg-gray-900', 'dark:text-gray-300'];
  }
};

export const formatDateTime = (date: string | Date): string => {
  return new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }).format(new Date(date))
}

export const cardClasses = (status: number | boolean): string[] => {
    switch (status) {
        case 1:
            return ['card-status-returned'];
        case 0:
            return ['card-status-out'];
        default:
            return ['border-l-4 border-gray-300 bg-white'];
    }
};