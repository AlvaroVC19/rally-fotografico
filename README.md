# 📸 Rally Fotográfico de Flores

Este proyecto es una plataforma web desarrollada con PHP y MySQL que permite gestionar un concurso fotográfico temático. Los participantes pueden registrarse, subir fotos, y el público puede votar. El administrador valida las fotos y puede ver estadísticas completas.

---

## 🚀 Despliegue con Docker

Este proyecto está preparado para ejecutarse con **Docker Desktop** y `docker-compose`, separando el servidor web y la base de datos como recomienda el enunciado.

### 📦 Requisitos previos

- Tener instalado:
  - [Docker Desktop](https://www.docker.com/products/docker-desktop/)
  - [Git](https://git-scm.com/)

---

## 📁 Estructura del proyecto

```
rally-fotografico/
├── docker/
│   └── php/                # Configuración del contenedor PHP-Apache
├── sql/
│   └── init.sql            # Script SQL para crear la BD y sus tablas
├── src/                    # Código fuente PHP
├── docker-compose.yml
└── README.md
```

---

## ⚙️ Cómo ejecutar el proyecto

1. 📥 Clona el repositorio:

```bash
git clone https://github.com/AlvaroVC19/rally-fotografico.git
cd rally-fotografico
```

2. 🐳 Inicia los contenedores:

```bash
docker-compose up -d
```

Esto levantará:
- Un contenedor `web` con Apache + PHP
- Un contenedor `db` con MySQL
- Un contenedor `phpmyadmin` accesible vía navegador

3. 📂 Accede a la app:

- Web: http://172.31.192.1:8080
- phpMyAdmin: http://172.31.192.1:8081  
  Usuario: `root`  
  Contraseña: `root`

---

## 🗃️ Persistencia de base de datos

La base de datos se guarda automáticamente en un volumen de Docker para que no se pierdan los datos entre reinicios.

---

## 🧪 Datos de prueba

Puedes modificar `sql/rally-fotografico.sql` para incluir datos de ejemplo (usuarios, fotos, votos, etc.).

---

## 🛠️ Notas técnicas

- El código fuente está en `src/` y se monta automáticamente en el contenedor Apache.
- El puerto 8080 es para la web, el 8081 para phpMyAdmin.
- Las fotos subidas se almacenan en `/src/uploads/`.

---

## 🧼 Para detener y limpiar todo

```bash
docker-compose down -v
```

---

## 📄 Licencia

Uso educativo para el módulo Proyecto Integrado - DAW.
