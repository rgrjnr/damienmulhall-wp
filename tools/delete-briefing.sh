#!/usr/bin/env bash
# Removes an unlisted briefing page and its PDF, rebuilds to prove it's gone,
# commits, and pushes master (which deploys) only after you confirm.
#
#   tools/delete-briefing.sh dell-sales-chat-691b44
set -euo pipefail

slug="${1:-}"
if [[ -z "$slug" ]]; then
  echo "Usage: tools/delete-briefing.sh <slug>   e.g. dell-sales-chat-691b44" >&2
  exit 1
fi

cd "$(dirname "$0")/.."

page="src/briefings/$slug.njk"
pdf="src/assets/files/briefings/$slug.pdf"
[[ -f "$page" ]] || { echo "No briefing at $page" >&2; exit 1; }

branch="$(git rev-parse --abbrev-ref HEAD)"
[[ "$branch" == "master" ]] || { echo "Switch to master first (on $branch)." >&2; exit 1; }
[[ -z "$(git status --porcelain)" ]] || { echo "Working tree has uncommitted changes; commit or stash them first." >&2; exit 1; }

git pull --ff-only -q origin master

git rm -q "$page"
[[ -f "$pdf" ]] && git rm -q "$pdf"

# Eleventy never cleans public/, so clear the old output before checking the build.
rm -rf "public/briefings/$slug" "public/assets/files/briefings/$slug.pdf"
npm run build >/dev/null
if grep -rqs "$slug" public; then
  echo "Build still references $slug; not committing." >&2
  git reset -q --hard HEAD
  exit 1
fi

git commit -q -m "Remove unlisted briefing $slug"
echo "Committed: $(git log --oneline -1)"

read -r -p "Push to master and take it off damienmulhall.com now? [y/N] " answer
if [[ "$answer" =~ ^[Yy]$ ]]; then
  git push -q origin master
  echo "Pushed. The page disappears once the deploy finishes (4 to 8 minutes)."
else
  echo "Not pushed. Run 'git push origin master' when you're ready."
fi
