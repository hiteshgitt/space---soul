# Space and Soul WordPress Theme

A modern, performance-optimized WordPress theme with Elementor integration, built with clean code and security in mind.

## Features

### 🚀 Performance
- Lazy loading for images
- Minified HTML output
- Optimized asset loading
- WebP image support
- Critical CSS inlined
- Deferred JavaScript loading

### 🔒 Security
- Input sanitization
- Output escaping
- XSS protection
- CSRF protection
- Security headers
- Login attempt limiting

### 🎨 Design
- Responsive design
- Mobile-first approach
- Clean, modern UI
- Customizable colors and typography
- Elementor integration
- Custom post types support

### 🔧 Developer Features
- WordPress coding standards compliant
- PSR-4 autoloading
- Namespaced code
- Modular structure
- Well-documented code
- Git version control ready

## Installation

1. Upload the theme folder to `/wp-content/themes/` directory
2. Activate the theme through the 'Appearance' menu in WordPress
3. Configure the theme options in the Customizer

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## Theme Structure

```
space-and-soul/
├── assets/
│   ├── css/
│   │   └── editor-style.css
│   └── js/
│       ├── main.js
│       └── customizer.js
├── inc/
│   ├── customizer.php
│   ├── elementor.php
│   ├── extras.php
│   ├── performance.php
│   ├── security.php
│   ├── seo.php
│   └── template-tags.php
├── style.css
├── index.php
├── functions.php
├── header.php
├── footer.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── 404.php
├── comments.php
├── searchform.php
└── README.md
```

## Customization

### Theme Options
The theme includes a comprehensive Customizer panel with options for:
- Layout settings
- Color scheme
- Typography
- Performance options
- SEO settings

### Elementor Integration
- Full Elementor support
- Custom widgets
- Theme builder integration
- Popup support
- Motion effects

### Hooks and Filters
The theme provides numerous hooks and filters for customization:
- `space_and_soul_before_content`
- `space_and_soul_after_content`
- `space_and_soul_post_meta`
- `space_and_soul_header`
- `space_and_soul_footer`

## Performance Optimization

### Lazy Loading
Images are automatically lazy-loaded using the Intersection Observer API with fallback for older browsers.

### Asset Optimization
- CSS and JavaScript are minified
- Unused WordPress features are disabled
- Critical CSS is inlined
- Non-critical JavaScript is deferred

### Database Optimization
- Unnecessary queries are removed
- Caching is implemented where appropriate
- Database queries are optimized

## Security Features

### Input Validation
All user inputs are sanitized and validated before processing.

### Output Escaping
All outputs are properly escaped to prevent XSS attacks.

### Security Headers
The theme adds security headers to protect against common attacks.

### Login Protection
- Failed login attempt limiting
- CAPTCHA support
- Custom login page styling

## SEO Features

### Meta Tags
- Automatic meta descriptions
- Open Graph tags
- Twitter Card support
- Canonical URLs
- Robots meta tags

### Structured Data
- JSON-LD structured data
- Breadcrumb schema
- Article schema
- Website schema

### Performance SEO
- Fast loading times
- Mobile-friendly design
- Clean, semantic HTML

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Changelog

### Version 1.0.0
- Initial release
- WordPress 6.4 compatibility
- Elementor integration
- Performance optimizations
- Security enhancements
- SEO features

## Support

For support, please contact the theme author or create an issue in the repository.

## License

This theme is licensed under the GPL v2 or later.

## Credits

- WordPress.org
- Elementor
- Modern CSS techniques
- Performance optimization best practices

---

**Author:** Hitesh Lendi  
**Version:** 1.0.0  
**Last Updated:** 2024
