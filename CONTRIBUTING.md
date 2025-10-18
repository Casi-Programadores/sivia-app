# Guía de Contribución – SIVIA-APP

A continuación se explicarán las pautas y buenas prácticas que se deberán seguir para trabajar en el proyecto `SIVIA-APP`.  
El objetivo es mantener un flujo de trabajo ordenado, claro y coherente entre todos los miembros del equipo, aplicando la metodología GitFlow.

---

## Flujo de ramas
El proyecto utilizará GitFlow con las siguientes ramas principales y auxiliares:

- **main** → Rama estable (producción).
- **develop** → Rama de integración (acumula features aprobadas).
- **feature/** → Ramas para nuevas funcionalidades.
- **release/** → Preparación de versión estable.
- **hotfix/** → Correcciones urgentes sobre `main`.

###  Reglas de nombres de ramas:
- Todo en minúsculas.
- Palabras separadas por guiones medios `-`.


### Pasos a seguir

1.  **Sincronizar**: Antes de empezar, asegúrate de que tu rama `develop` esté actualizada:
    ```bash
    git checkout develop
    git pull origin develop
    ```
2.  **Crear una rama de trabajo**: Crea una nueva rama para tu funcionalidad o corrección:
    ```bash
    git checkout -b feature/nombre-de-la-funcionalidad
    ```
3.  **Hacer cambios**: Realiza tus cambios, haciendo commits pequeños y atómicos que sigan las pautas de `Convenciones de Commits`.
4.  **Abrir un Pull Request (PR)**: Una vez que tu trabajo esté completo, sube tu rama al repositorio remoto y abre un `Pull Request` en Github. El destino del PR debe ser la rama `develop`.
5.  **Revisión de pares**: Solicita la revisión de un compañero. La solicitud debe contar con una aprobación mínima para ser aceptada.

---

## Convenciones de Nomenclatura

| Elemento                 | Convención               | Ejemplo                                        |
| ------------------------ | ------------------------ | ---------------------------------------------- |
| **Métodos / Funciones**  | `camelCase`              | `calculateTotal()`, `registerRequest()`        |
| **Variables**            | `camelCase`              | `$totalAmount`, `$startDate`                   |
| **Constantes**           | `MAYÚSCULAS_CON_GUIONES` | `MAX_TRAVEL_ALLOWANCE`                         |
| **Controladores**        | `Singular + Controller`  | `RequestController`                            |
| **Modelos**              | `PascalCase` y singular  | `User`                                         |
| **Vistas**               | `kebab-case`             | `travel-request-form.blade.php`                |

---

## Convenciones de Commits

Todos los commits deben escribirse con la siguiente convención.  
- Mensajes cortos y descriptivos.  
- Formato recomendado:  
    tipo(scope): descripción breve

- Formato General
    ```bash
    <tipo>(<ámbito opcional>): <resumen en presente, imperativo>
    <contexto/motivo breve>
    Punto 1
    Closes #<n> 
    ```

- **Tipos más usados**:  
- `feat`: nueva funcionalidad  
- `fix`: corrección de bug  
- `docs`: cambios en documentación  

Ej:

    feat(sales): agrega cálculo de total con impuestos y descuentos

    Se incorpora el cálculo de IVA y descuentos por cliente recurrente.
    Incluye DTO y actualización del service.

    Closes #12

---

## Buenas Prácticas de Desarrollo

- Mantener el código limpio, comentado y legible.
- Validar datos antes de enviarlos o almacenarlos.
- Probar cada funcionalidad antes de crear el Pull Request.
- Evitar subir archivos innecesarios (usar .gitignore).
- Usar nombres descriptivos en clases, métodos y variables.