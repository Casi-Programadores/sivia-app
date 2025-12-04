# SISTEMA INTEGRAL DE VIÁTICOS Y ADMINISTRACIÓN (SIVIA)

## TRABAJO FINAL INTEGRADOR (TFI)

### UNIVERSIDAD TECNOLÓGICA NACIONAL (UTN)
**Facultad Regional Resistencia (FRRe)**

**Carrera:** Tecnicatura Universitaria en Programación (TUP).

**Asignatura/Instancia:** Trabajo Final Integrador - 3ra Instancia de Evaluación.

**Título del Proyecto:** Implementación de un Sistema Integral de Viáticos y Administración (SIVIA) para la DPV Formosa.

***

## EQUIPO DE DESARROLLO

* **Justiniano, Max Angel**
* **Mora, Sebastian Marcelo**
* **Villalba, Lourdes**

***

## 1. Introducción general

La Dirección Provincial de Vialidad de Formosa (DPV) gestiona frecuentemente los **viáticos** del personal en comisión de servicio. Este procedimiento se realiza actualmente de manera **manual** mediante planillas Excel individuales, que se imprimen, firman y archivan.

Esta metodología tradicional presenta **limitaciones** significativas, como la carga repetitiva de datos, la alta propensión a errores humanos, las demoras en la tramitación y la dificultad para acceder a un registro histórico organizado. Estos problemas afectan directamente la eficiencia administrativa y la trazabilidad de la información.

Como **solución**, se propone el desarrollo de **SIVIA**, un **sistema web automatizado** diseñado para **digitalizar y optimizar** el proceso de generación y registro de viáticos. El sistema está diseñado para generar formularios en **formato PDF** precargados con datos del personal y registrará automáticamente la información en una base de datos centralizada, mejorando la **eficiencia, el control y la transparencia** del proceso.

## 2. Objetivo del proyecto

El objetivo general del proyecto es:

> **Desarrollar un sistema que permita generar formularios de viáticos de manera automatizada, con datos precargados, generando un archivo PDF listo para firmar, y que a su vez registre automáticamente la información en una base de datos centralizada para su consulta, seguimiento y control.**

Para cumplir este objetivo, el sistema permite al usuario:
* Registrar la solicitud de viático a través de un formulario digital.
* Obtener la **precarga automática** de datos del personal.
* Generar las planillas de Solicitud, Certificación y Liquidación en **formato PDF oficial** listas para su impresión.
* Crear la planilla de **certificación individual** vinculada a la solicitud aprobada.
* Generar la planilla de **liquidación individual** por persona.
* Generar la planilla de **consolidación mensual** de viáticos con opción a exportación a Excel y PDF.
* Realizar la **búsqueda y el filtrado** de registros de viáticos por empleado, fecha o destino, y visualizar el historial de solicitudes.

***

## 3. Análisis de Requerimientos

La fase inicial del proyecto se centró en la **Planificación y el Análisis de Requisitos**. El objetivo principal fue transformar el proceso de gestión de viáticos, que era enteramente manual (basado en planillas Excel, propenso a errores y con deficiencias en la trazabilidad de la información), en un flujo digital, automatizado y auditable.

Para ello, se realizaron tareas de **relevamiento de información** con el personal de la DPV, lo que permitió definir el **alcance funcional** y recopilar de forma exhaustiva los **Requerimientos Funcionales (RF)** y **No Funcionales (RNF)**. Este proceso culminó con la elaboración de un **Documento de Especificación de Requisitos de Software (ERS)**, que sirvió como base para todo el diseño y desarrollo del sistema.

---

## 4. Requerimientos del Sistema (RF y RNF)

Los requisitos recabados se clasificaron de la siguiente manera:

### 4.1. Requerimientos Funcionales (RF)

| ID | Requerimiento Funcional | Prioridad |
| :--- | :--- | :--- |
| **RF-01** | Inicio de sesión mediante usuario y contraseña  | Esencial |
| **RF-02** | Asignación de roles diferenciados (Administrador / Empleado) con restricciones de acceso  | Esencial |
| **RF-03** | Registro de solicitud de viático a través de formulario digital  | Esencial |
| **RF-04** | Precarga automática de datos del personal desde la base de datos  | Esencial |
| **RF-05** | Inclusión de múltiples personas en una misma solicitud (mismo destino y fecha)  | Esencial |
| **RF-07** | Creación de planilla de certificación individual vinculada a la solicitud aprobada  | Esencial |
| **RF-08** | Generación de la planilla de liquidación individual por persona  | Esencial |
| **RF-09** | Generación de las planillas en formato **PDF oficial** (listas para impresión con espacios para firmas)  | Esencial |
| **RF-10** | Creación de planilla de consolidación mensual de viáticos  | Útil |
| **RF-15** | El sistema debe registrar el estado de cada trámite (pendiente, aprobado, cancelado)  | Esencial |
| **RF-16** | Gestión de datos de personal (alta, baja, modificación)  | Útil |

### 4.2. Requerimientos No Funcionales (RNF)

| Aspecto | Requerimiento No Funcional |
| :--- | :--- |
| **Usabilidad** | Interfaz intuitiva, amigable, con menús claros y formularios simples. Deberá contar con mensajes de ayuda y validación de datos. |
| **Rendimiento** | El tiempo de respuesta para operaciones frecuentes no deberá superar **2 segundos** en el 95% de los casos. Generación de documentos PDF en menos de **3 segundos**. |
| **Seguridad** | Implementar autenticación mediante usuario y contraseña encriptada (hash)  y utilizar conexiones seguras (**HTTPS**). |
| **Mantenibilidad** | Desarrollo con **arquitectura modular** para facilitar la corrección de errores y la ampliación de funcionalidades. |
| **Portabilidad** | Ejecutable en navegadores modernos (Chrome, Firefox, Edge) [cite: 1582] y adaptable a distintos dispositivos (**responsive**). |

---

## 5. Tecnologías Utilizadas

El proyecto SIVIA se desarrolló utilizando un *stack* de tecnologías modernas centrado en el ecosistema de PHP, adoptando un enfoque de desarrollo full-stack con componentes reactivos para asegurar una experiencia de usuario ágil y un desarrollo eficiente.

| Componente | Tecnología | Función Principal |
| :--- | :--- | :--- |
| **Backend / Lógica** | **Laravel 12** / **Livewire**  | Desarrollo de la lógica de negocio, arquitectura MVC y gestión de la comunicación con la base de datos. |
| **Frontend / UI** | **Blade** + **TailwindCSS** - **Livewire**| Construcción de la interfaz de usuario, garantizando un diseño responsive y una experiencia dinámica sin recargas de página. |
| **Base de Datos** | **MySQL**  | Almacenamiento, consulta y gestión de datos. |
| **Generación de Docs** | **Dompdf**  | Utilizado específicamente para la generación de las planillas oficiales en formato PDF. |
| **Herramientas** | **Figma**, **GitHub**, **Jira**, **Laravel Excel**  | Maquetación y prototipado (Figma), control de versiones (GitHub), gestión ágil de proyectos (Jira), y exportaciones de datos a Excel (Laravel Excel). |

---

## 6. Alcance del Proyecto

El alcance del proyecto SIVIA se limita a la **digitalización integral** del proceso de viáticos dentro de la Dirección Provincial de Vialidad de Formosa (DPV).

El sistema cubre el ciclo de vida completo de la documentación, desde la solicitud inicial hasta el cierre contable, incluyendo la generación de los tres documentos clave requeridos por la institución: **Solicitud**, **Certificación** y **Liquidación**.

El proyecto incluye:
1.  **Módulo de Autenticación y Roles** (Administrador / Empleado).
2.  **Módulo de Solicitudes**, con precarga automática de datos y gestión de estados.
3.  **Módulos de Certificación y Liquidación** individual.
4.  **Módulo de Reportes**, que incluye historial, búsqueda avanzada y consolidación mensual con exportación.
5.  **Gestión de Datos de Personal** (CRUD).

**Exclusiones:** El sistema **no** gestiona el proceso de pago ni se integra directamente con sistemas de tesorería o contabilidad externos, limitándose a generar la documentación oficial necesaria para la tramitación administrativa interna y su registro en la base de datos.
