---
description: Create a new release with version bump and build
---

# Release Workflow

Follow these steps to create a new release:

1. **Commit all pending changes** to the `develop` branch.
2. **Start the release branch** (inference of version bump type: major, minor, or patch):
   ```bash
   git flow release start vX.Y.Z
   ```
3. **Bump the version** in the following files:
   - `tailwind/custom/file-header.css`
   - `theme/style.css` (though this will be updated by build, it's good to keep in sync)
4. **Update the changelog**:
   - Add a new entry to `CHANGELOG.md` with the new version and changes.
5. // turbo
   **Run the production build**:
   ```bash
   pnpm production
   ```
6. **Commit the version bump and build results**:
   ```bash
   git add .
   git commit -m "chore: bump version to X.Y.Z and build"
   ```
7. **Finish the release**:
   ```bash
   git flow release finish -m "vX.Y.Z" vX.Y.Z
   ```
8. **Push changes and tags**:
   ```bash
   git push origin develop
   git push origin master --tags
   ```
