======================================================
FILE: skills/gitflow-hotfix-branch/SKILL.md
======================================================
---
name: gitflow-hotfix-branch
description: Use this skill to create and finish GitFlow hotfix branches for urgent production bugs, aligned with Semantic Versioning.
---

# GitFlow Hotfix Branch Skill

Goal
Help the user quickly patch critical issues on the production branch using GitFlow hotfix branches, updating the SemVer patch version and propagating fixes back to develop.

## When to use

Use this skill when the user says:
- "Create a hotfix for production"
- "Fix a critical bug on main"
- "Prepare hotfix v1.2.1"

## Assumptions

- GitFlow is initialized.
- main (or master) represents the production branch with tagged releases.
- The project uses Semantic Versioning: MAJOR.MINOR.PATCH.
- Hotfixes generally bump the PATCH number (e.g., 1.2.0 -> 1.2.1).

## Naming convention

- Use prefix hotfix/.
- Recommended name: hotfix/X.Y.Z
  - Example: hotfix/1.2.1.

## Starting a hotfix

1. Ensure the working tree is clean:
   git status

2. Check out the production branch and pull latest:
   git checkout main
   git pull origin main

3. Decide the new patch version (e.g., from 1.2.0 to 1.2.1).

4. Start the hotfix:
   git flow hotfix start 1.2.1

   This creates and checks out hotfix/1.2.1 from main.

## Working on a hotfix

- Apply the minimal changes needed to fix the production issue.
- Commit with clear messages:
  git add .
  git commit -m "fix: correct hero block query on homepage"

- If the project uses version fields in code (e.g. plugin header),
  bump them inside the hotfix branch per team convention.

## Finishing a hotfix

1. When the fix is tested and ready, run:
   git flow hotfix finish 1.2.1

   This will:
   - Merge hotfix/1.2.1 into main.
   - Tag the merge commit with 1.2.1 (or v1.2.1 depending on config).
   - Merge the same hotfix back into develop.
   - Delete the local hotfix branch.

2. Push branches and tags:
   git push origin main
   git push origin develop
   git push origin --tags

## Versioning guidelines

- For hotfix branches, only PATCH is incremented (e.g., 1.2.0 -> 1.2.1).
- Ensure version numbers are consistent in:
  - WordPress plugin or theme headers.
  - CHANGELOG.md.
  - composer.json or package.json if present.

## Safety checks

- Only use hotfix branches for production-critical issues that cannot wait for the next regular release.
- If a release branch is open simultaneously:
  - Ensure hotfix changes are merged into both main and develop.
  - Cherry-pick into the open release branch if needed.
- Avoid force pushes on main and develop.

## Example conversation

User: "Production is at 2.0.0, we need a quick fix for the login redirect bug."
Agent:
- Proposes new version 2.0.1.
- Instructs:
  git checkout main
  git pull origin main
  git flow hotfix start 2.0.1

- After committing the fix, instructs:
  git flow hotfix finish 2.0.1
  git push origin main
  git push origin develop
  git push origin --tags