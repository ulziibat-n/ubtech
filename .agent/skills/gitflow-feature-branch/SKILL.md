======================================================
FILE: skills/gitflow-feature-branch/SKILL.md
======================================================
---
name: gitflow-feature-branch
description: Use this skill to create, work on, and finish GitFlow feature branches for a WordPress project.
---

# GitFlow Feature Branch Skill

Goal
Help the user create and manage GitFlow feature branches for new functionality in their WordPress theme or plugin, following a clear naming convention and clean history.

## When to use

Use this skill when the user says things like:
- "Start a feature for X"
- "Create a feature branch for ticket ABC-123"
- "Finish this feature and merge it back to develop"
- "Sync my feature branch with the latest develop"

## Assumptions

- GitFlow is already initialized in the repo (git flow init has been run with the desired preset).
- Main branches are main (or master) and develop.
- The user is comfortable running basic git commands from the terminal.

## Naming convention

- Use prefix feature/.
- Recommended pattern: feature/<ticket-id>-<short-description>
  - Example: feature/ABC-123-hero-block or feature/hero-block-layout.
- Keep names lowercase, use hyphens instead of spaces.

## Starting a feature

1. Ensure the working tree is clean:
   git status

2. Switch to develop and pull latest changes:
   git checkout develop
   git pull origin develop

3. Start the feature using GitFlow:
   git flow feature start FEATURE_NAME
   # Example:
   git flow feature start hero-block-layout

   This will:
   - Create a new branch feature/FEATURE_NAME based on develop.
   - Check out that branch.

4. If the user wants to start from a specific base branch or commit:
   git flow feature start FEATURE_NAME BASE
   # Example:
   git flow feature start hero-block-layout origin/develop

5. Push the feature branch to origin for collaboration:
   git push -u origin feature/FEATURE_NAME

## Working on a feature

- Stage and commit changes as usual:
  git add .
  git commit -m "feat: add hero block template"

- Use clear commit messages (Conventional Commits style is recommended):
  - feat: for new features.
  - fix: for bug fixes.
  - refactor:, chore:, docs: as needed.

- If develop has moved forward and the user requests to update the feature branch:
  git checkout feature/FEATURE_NAME
  git fetch origin
  git rebase origin/develop
  # or, if the team prefers merge:
  # git merge origin/develop

- Resolve any conflicts, then continue rebase if applicable:
  git add <resolved-files>
  git rebase --continue

## Finishing a feature

1. Ensure the feature branch has no uncommitted changes and tests pass:
   git status

2. Optionally open a pull request from feature/FEATURE_NAME into develop and wait for review.

3. Finish the feature using GitFlow:
   # If the feature branch is currently checked out:
   git flow feature finish

   # Or explicitly by name:
   git flow feature finish FEATURE_NAME

   This will typically:
   - Merge feature/FEATURE_NAME into develop (non-fast-forward).
   - Delete the local feature branch (depending on GitFlow config).
   - Switch back to develop.

4. Push updated develop (and delete remote branch if desired):
   git checkout develop
   git push origin develop

   # Optionally remove remote branch:
   git push origin --delete feature/FEATURE_NAME

## Safety checks

- Do not start a feature from main or release branches unless explicitly requested.
- Before finishing a feature:
  - Confirm that all work is committed.
  - Confirm that the feature is up to date with develop (rebase/merge).
- Prefer the explicit git flow feature finish FEATURE_NAME form over the shorthand.

## CI / build considerations

- If the repo has CI:
  - Make sure the feature branch builds successfully before feature finish.
  - If tests/build fail, guide the user to fix and recommit on the feature branch.

## Example conversation

User: "Create a feature branch for the new pricing table block, ticket WP-124."
Agent:
- Suggests the branch name feature/WP-124-pricing-table-block.
- Instructs:
  git checkout develop
  git pull origin develop
  git flow feature start WP-124-pricing-table-block
  git push -u origin feature/WP-124-pricing-table-block

- Later, when the feature is done and reviewed, instructs:
  git checkout feature/WP-124-pricing-table-block
  git flow feature finish WP-124-pricing-table-block
  git push origin develop
  git push origin --delete feature/WP-124-pricing-table-block