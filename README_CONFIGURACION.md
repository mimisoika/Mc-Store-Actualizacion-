# 🎨 Sistema de Configuración Centralizado - MC Store

## 📋 Descripción General

Se ha implementado un **sistema completo de configuración centralizado** que permite administrar todo el contenido y la personalización visual de la página desde un único panel de control profesional.

## ✨ Características Principales

### 1. 🎛️ Panel de Control Unificado
- Ubicado en: **Admin → Configuración**
- 4 pestañas organizadas temáticamente
- Interfaz moderna y profesional
- Validación de datos automática
- Cambios aplicados al instante

### 2. 📝 Gestión de Contenido
- **Nombre del Sitio**: Configurable en toda la página
- **Logo Personalizado**: Upload con preview en tiempo real
- **Texto Nosotros**: Contenido de la sección "Acerca de"
- **Datos de Contacto**: Dirección, teléfono, email, WhatsApp, redes sociales
- **Horarios**: Formato flexible multilínea

### 3. 🎨 Personalización Visual
- **Color Primario**: Botones, iconos, elementos destacados
- **Color Secundario**: Títulos y encabezados
- **Color Encabezado**: Fondo de la barra de navegación
- **Color Texto**: Texto general de la página
- **Preview en Tiempo Real**: Ve los cambios al seleccionar

### 4. 🖼️ Gestión de Carrusel
- Upload de múltiples imágenes
- Edición de título y descripción
- Activar/desactivar imágenes
- Reordenamiento por orden
- Eliminación de imágenes
- Soporte para JPG, PNG, GIF, WebP

## 📁 Estructura de Archivos

### Nuevos Archivos Creados

```
pages/admin/functions/
├── f_configuracion.php          # Funciones principales
└── f_gestion_carrusel.php       # Gestión del carrusel

php/
└── crear_tabla_configuracion.php # Script de instalación

INSTRUCCIONES_CONFIGURACION.txt   # Guía de uso
RESUMEN_CONFIGURACION.txt         # Resumen técnico
verificacion_configuracion.php     # Herramienta de verificación
```

### Archivos Modificados

```
pages/admin/
└── configuracion.php              # Nueva interfaz de 4 pestañas

pages/
├── header.php                     # Logo y colores dinámicos
├── footer.php                     # Datos de contacto dinámicos
└── admin/css/admin_style.css      # Estilos nuevos

index.php                          # Carrusel y contenido dinámicos
```

## 🚀 Instalación Rápida

### Paso 1: Crear las Tablas
```
1. Abre en navegador: http://localhost/Proyecto-Sin-IA-main/php/crear_tabla_configuracion.php
2. Espera el mensaje "✓ Base de datos configurada correctamente"
3. (Opcional) Borra el archivo crear_tabla_configuracion.php por seguridad
```

### Paso 2: Acceder al Panel
```
1. Inicia sesión como administrador
2. Ve al menú: Configuración
3. Completa los datos en cada pestaña
4. Haz clic en "Guardar Cambios"
```

### Paso 3: Verificar
```
Abre: http://localhost/Proyecto-Sin-IA-main/verificacion_configuracion.php
Para comprobar que todo está funcionando correctamente.
```

## 🔧 Funciones Disponibles

### Configuración General

```php
// Obtener configuración actual
$config = obtenerConfiguracion();

// Actualizar configuración
actualizarConfiguracion($datos);

// Upload de logo
subirLogo($archivo);

// Generar CSS dinámico
$css = generarCssDinamico();
```

### Gestión de Carrusel

```php
// Obtener imágenes activas
$imagenes = obtenerImagenesCarrusel();

// Obtener todas las imágenes
$imagenes = obtenerTodasImagenesCarrusel();

// Agregar imagen
agregarImagenCarrusel($titulo, $descripcion, $archivo);

// Actualizar imagen
actualizarImagenCarrusel($id, $titulo, $descripcion);

// Eliminar imagen
eliminarImagenCarrusel($id);

// Activar/Desactivar
activarDesactivarImagenCarrusel($id, $activa);

// Reordenar
reordenarCarrusel($orden);
```

## 🗄️ Base de Datos

### Tabla: configuraciones
```sql
CREATE TABLE configuraciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_sitio VARCHAR(100),
    logo_url VARCHAR(255),
    color_primario VARCHAR(7),
    color_secundario VARCHAR(7),
    color_encabezado VARCHAR(7),
    color_texto VARCHAR(7),
    texto_nosotros LONGTEXT,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    email VARCHAR(100),
    horarios TEXT,
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    whatsapp VARCHAR(20),
    fecha_actualizacion TIMESTAMP
);
```

### Tabla: carrusel_imagenes
```sql
CREATE TABLE carrusel_imagenes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100),
    descripcion TEXT,
    imagen_url VARCHAR(255),
    orden INT,
    activa BOOLEAN,
    fecha_creacion TIMESTAMP
);
```

## 🌐 Páginas Afectadas

### index.php
- ✅ Carrusel dinámico
- ✅ Sección "Nosotros" dinámica
- ✅ Datos de contacto dinámicos
- ✅ Colores personalizados
- ✅ Logo dinámico

### pages/header.php
- ✅ Nombre del sitio dinámico
- ✅ Logo dinámico
- ✅ Colores de encabezado personalizados

### pages/footer.php
- ✅ Datos de contacto dinámicos
- ✅ Enlaces a redes sociales dinámicos
- ✅ Color de fondo personalizado

### Todas las páginas
- ✅ CSS dinámico con variables de color
- ✅ Colores consistentes en toda la página

## 💾 Estructura de Datos

### Colores
Los colores se guardan en formato hexadecimal:
```
#0066CC  (primario)
#333333  (secundario)
#FFFFFF  (encabezado)
#000000  (texto)
```

### Imágenes
Se guardan en:
- Logo: `pages/img/logo-mcstore.png`
- Carrusel: `pages/img/slider/slide_TIMESTAMP_RANDOM.ext`

## 📋 Validaciones

### Imágenes
- **Tipos**: JPG, PNG, GIF, WebP
- **Logo**: Máximo 5MB
- **Carrusel**: Máximo 10MB

### Campos
- **Nombre**: Máximo 100 caracteres
- **Email**: Validación de formato
- **Teléfono**: Acepta espacios y símbolos
- **URLs**: Validación básica de formato

## 🔐 Seguridad

✅ **Validación de Datos**
- Sanitización de inputs
- Escape de salida con `htmlspecialchars()`
- Validación de tipos de archivo

✅ **Control de Acceso**
- Solo administradores pueden acceder
- Verificación de sesión
- Protección CSRF (recomendado)

✅ **Almacenamiento**
- Preparación de consultas (mysqli_real_escape_string)
- Validación de directorios
- Gestión segura de archivos

## 📊 Ejemplo de Uso

### Cambiar el nombre del sitio
```
1. Ve a: Admin → Configuración → General
2. Modifica "Nombre del Sitio"
3. Haz clic en "Guardar Cambios"
4. Se actualiza en el navbar y todas las páginas
```

### Personalizar colores
```
1. Ve a: Admin → Configuración → Colores
2. Haz clic en los selectores de color
3. Ve el preview en tiempo real
4. Haz clic en "Guardar Colores"
5. Los cambios se aplican al instante
```

### Agregar imágenes al carrusel
```
1. Ve a: Admin → Configuración → Carrusel
2. Completa: Título y Descripción
3. Sube la imagen
4. Haz clic en "Subir Imagen"
5. La imagen aparecerá en el slider del inicio
```

## 🐛 Solución de Problemas

### Las tablas no se crean
- ✓ Ejecuta: `php/crear_tabla_configuracion.php`
- ✓ Verifica la conexión a BD
- ✓ Revisa los permisos de BD

### Las imágenes no se suben
- ✓ Verifica permisos de carpeta: `pages/img/slider/`
- ✓ Revisa el tamaño máximo en PHP
- ✓ Comprueba el espacio en disco

### Los colores no cambian
- ✓ Borra caché del navegador (Ctrl+Shift+Delete)
- ✓ Verifica que se guardó correctamente
- ✓ Abre la página en incógnito

### El logo no aparece
- ✓ Verifica que la carpeta `pages/img/` existe
- ✓ Revisa los permisos de lectura
- ✓ Abre la ruta directamente en navegador

## 📞 Soporte

Para verificar el estado del sistema:
```
Abre: http://localhost/Proyecto-Sin-IA-main/verificacion_configuracion.php
```

Esta página muestra:
- Estado de tablas
- Configuración actual
- Archivos creados
- Directorios de subida
- Imágenes del carrusel

## 🎯 Características Futuras (Opcional)

Puedes extender este sistema agregando:
- [ ] Gestión de métodos de pago
- [ ] Configuración de impuestos
- [ ] Banners publicitarios
- [ ] Integración con redes sociales
- [ ] Análisis de visitantes
- [ ] Backup automático
- [ ] Control de versiones
- [ ] Historial de cambios

## ✅ Checklist de Implementación

- [x] Crear tablas de BD
- [x] Crear funciones de configuración
- [x] Crear página de administración
- [x] Integrar en index.php
- [x] Integrar en header.php
- [x] Integrar en footer.php
- [x] Agregar estilos CSS
- [x] Validación de datos
- [x] Upload de archivos
- [x] Gestión de carrusel
- [x] CSS dinámico
- [x] Documentación

## 📝 Notas Importantes

1. **Respaldos**: Haz respaldos periódicos de tu BD
2. **Permisos**: Asegúrate de que las carpetas tienen permisos 755 o 777
3. **Colores**: Usa colores con suficiente contraste para accesibilidad
4. **Imágenes**: Optimiza las imágenes antes de subirlas
5. **Seguridad**: No elimines el archivo de configuración de BD

## 🎉 ¡Listo para Usar!

Tu sistema de configuración está completo y funcional. Ahora puedes administrar toda tu tienda desde un panel centralizado sin editar código.

**¿Preguntas?** Revisa los archivos de instrucciones incluidos.

---

**Última actualización**: Noviembre 2024
**Versión**: 1.0
**Estado**: ✅ Completamente Funcional
