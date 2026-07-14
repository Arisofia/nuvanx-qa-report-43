# Instrucciones de Rollback

Si el despliegue a producción causa algún problema de diseño o funcionalidad, ejecutar los siguientes pasos para restaurar el CSS.

1. Conectarse al servidor por SSH.
2. Navegar a `/home/customer/www/nuvanx.com/public_html/wp-content/themes/nuvanx-medical/assets/css/`
3. Extraer el CSS desde el backup de staging:
   ```bash
   tar -xzf /home/u54-jiiuzkghob55/nuvanx-backups/nuvanx-medical-ticket43-before-20260714-140013.tar.gz -C /tmp/
   cp /tmp/.../theme/assets/css/nvx-brand-home.css ./nvx-brand-home.css
   ```
4. Purgar la caché usando `wp sg purge`.
5. Tiempo estimado de recuperación: **2 minutos**.
