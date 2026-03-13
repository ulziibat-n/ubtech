---
name: semver-gitflow-release
description: Use this skill to plan and execute a Semantic Versioning-based release using GitFlow for a WordPress theme or plugin, including version bump, changelog, and git tags.
---

# SemVer GitFlow Release Skill

Goal  
Help the user create a consistent release using GitFlow and Semantic Versioning (MAJOR.MINOR.PATCH) for a WordPress project.

## When to use

Use this skill when the user says:
- "Prepare a new release"
- "Create a release branch for v1.2.0"
- "Bump version and generate changelog"

## Instructions

1. Analyze the request:
   - Determine whether this is a major, minor, or patch release.
   - If not specified, infer from the changes:
     - Major: breaking changes.
     - Minor: new features, backward compatible.
     - Patch: bug fixes, small changes only.

2. Determine the next version:
   - Read the current version from:
     - `style.css` (for themes) or
     - main plugin file header (`Version:`) or
     - `package.json` if present.
   - Calculate the next SemVer version according to the requested bump type.

3. GitFlow operations:

   - Use the following command structure:

     ```bash
     git flow release start vX.Y.Z
     # commit version bumps and changelog
     git flow release finish vX.Y.Z
     git push origin develop
     git push origin main --tags
     ```

   - Replace `vX.Y.Z` with the computed version string.

4. Version bump:

   - Update the version in:
     - WordPress plugin header or theme header (`Version: X.Y.Z`).
     - Any composer/npm files if they exist.
   - Ensure all occurrences are in sync.

5. Changelog generation:

   - Read the git commit history since the last tag.
   - Group commits using Conventional Commits types if available:
     - `feat`, `fix`, `docs`, `refactor`, etc.
   - Produce a `CHANGELOG.md` entry like:

     ```md
     ## [1.2.0] - 2026-03-13
     ### Added
     - ...

     ### Fixed
     - ...
     ```

   - If the user requests, run a script:

     ```bash
     bash scripts/create_release.sh 1.2.0 minor
     ```

6. Safety checks:

   - Ensure the working tree is clean before starting a release:
     - Run `git status` and confirm no uncommitted changes.
   - Confirm the correct base branch (`develop`) is checked out.
   - If there are unmerged feature branches, warn the user.

7. Output:

   - Clearly list:
     - New version number.
     - Files where the version was updated.
     - Git commands that were or should be run.
     - New tag name (e.g., `v1.2.0`).

## Constraints

- Do not guess breaking changes. If unclear, ask the user whether this is a major or minor release.
- Do not force-push to remote branches.
- Do not create tags without bumping versions in source files.

## Example

User: "Create a minor release for the plugin, current version is 1.1.3."  
Agent:
- Proposes new version `1.2.0`.
- Updates the plugin header to `Version: 1.2.0`.
- Prepares a `CHANGELOG.md` entry.
- Suggests running `git flow release start v1.2.0`, then `git flow release finish v1.2.0`.
